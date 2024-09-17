#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <curl/curl.h>

//  armazenar os resultados da base local
typedef struct {
    char nome[100];
    char estudante[100];
} ResultadoLocal;

// armazenar os resultados da consulta SPARQL
typedef struct {
    char ocupacao[100];
} ResultadoWikidata;

// para ler resultados da base local
int lerResultadosBaseLocal(const char *arquivo, ResultadoLocal **resultados, int *numResultados) {
    FILE *fp = fopen(arquivo, "r");
    if (!fp) {
        perror("Erro ao abrir arquivo de resultados locais");
        return -1;
    }

    *numResultados = 0;
    char linha[256];
    while (fgets(linha, sizeof(linha), fp)) {
        (*numResultados)++;
    }
    rewind(fp);

    *resultados = malloc(*numResultados * sizeof(ResultadoLocal));
    if (!*resultados) {
        perror("Erro ao alocar memória");
        fclose(fp);
        return -1;
    }

    int i = 0;
    while (fgets(linha, sizeof(linha), fp)) {
        sscanf(linha, "%99[^,],%99[^\n]", (*resultados)[i].nome, (*resultados)[i].estudante);
        i++;
    }
    fclose(fp);
    return 0;
}

//escrever a resposta da consulta SPARQL em uma string
size_t write_callback(void *contents, size_t size, size_t nmemb, void *userp) {
    size_t total_size = size * nmemb;
    char **response_ptr = (char **)userp;
    *response_ptr = realloc(*response_ptr, total_size + 1);
    if (*response_ptr == NULL) {
        fprintf(stderr, "Erro ao realocar memória\n");
        return 0;
    }
    memcpy(*response_ptr, contents, total_size);
    (*response_ptr)[total_size] = '\0';
    return total_size;
}

//  envia a consulta SPARQL e recebe os resultados
char *enviarConsultaSPARQL(const char *consulta) {
    CURL *curl;
    CURLcode res;
    char *response = malloc(1);
    if (!response) {
        fprintf(stderr, "Erro ao alocar memória para resposta\n");
        return NULL;
    }
    response[0] = '\0';

    curl_global_init(CURL_GLOBAL_DEFAULT);
    curl = curl_easy_init();
    if (!curl) {
        fprintf(stderr, "Erro ao inicializar CURL\n");
        free(response);
        curl_global_cleanup();
        return NULL;
    }

    curl_easy_setopt(curl, CURLOPT_URL, "https://query.wikidata.org/sparql");
    curl_easy_setopt(curl, CURLOPT_POSTFIELDS, consulta);
    curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_callback);
    curl_easy_setopt(curl, CURLOPT_WRITEDATA, &response);
    curl_easy_setopt(curl, CURLOPT_HTTPHEADER, curl_slist_append(NULL, "Accept: application/sparql-results+json"));

    res = curl_easy_perform(curl);
    if (res != CURLE_OK) {
        fprintf(stderr, "Erro na solicitação CURL: %s\n", curl_easy_strerror(res));
        free(response);
        response = NULL;
    }

    curl_easy_cleanup(curl);
    curl_global_cleanup();
    return response;
}

// Função para processar a resposta SPARQL (simplificada)
int processarRespostaSPARQL(const char *resposta, ResultadoWikidata **resultados, int *numResultados) {
    
    *numResultados = 1; // Número fictício
    *resultados = malloc(*numResultados * sizeof(ResultadoWikidata));
    if (!*resultados) {
        perror("Erro ao alocar memória para resultados Wikidata");
        return -1;
    }
    strcpy((*resultados)[0].ocupacao, "Exemplo");
    return 0;
}

//  combina os resultados e salva no arquivo de resultado
void combinarResultados(const ResultadoLocal *locais, int numLocais, const ResultadoWikidata *wikidata, int numWikidata, const char *arquivoResultado) {
    FILE *fp = fopen(arquivoResultado, "w");
    if (!fp) {
        perror("Erro ao abrir arquivo de resultado");
        return;
    }

    for (int i = 0; i < numLocais; i++) {
        for (int j = 0; j < numWikidata; j++) {
            fprintf(fp, "Nome: %s, Estudante: %s, Ocupacao: %s\n", locais[i].nome, locais[i].estudante, wikidata[j].ocupacao);
        }
    }
    fclose(fp);
}

int main() {
    ResultadoLocal *resultadosLocais;
    int numResultadosLocais;
    if (lerResultadosBaseLocal("resultadoProprietaria.txt", &resultadosLocais, &numResultadosLocais) != 0) {
        return EXIT_FAILURE;
    }

    const char *consulta = "https://query.wikidata.org/sparql"; 
    char *respostaSPARQL = enviarConsultaSPARQL(consulta);
    if (!respostaSPARQL) {
        free(resultadosLocais);
        return EXIT_FAILURE;
    }

    ResultadoWikidata *resultadosWikidata;
    int numResultadosWikidata;
    if (processarRespostaSPARQL(respostaSPARQL, &resultadosWikidata, &numResultadosWikidata) != 0) {
        free(resultadosLocais);
        free(respostaSPARQL);
        return EXIT_FAILURE;
    }
    free(respostaSPARQL);

    combinarResultados(resultadosLocais, numResultadosLocais, resultadosWikidata, numResultadosWikidata, "resultadoFinal.txt");

    free(resultadosLocais);
    free(resultadosWikidata);
    return EXIT_SUCCESS;
}
