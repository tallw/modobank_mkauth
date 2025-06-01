import requests
import json
import logging
from requests.packages.urllib3.exceptions import InsecureRequestWarning

# Suprimindo o aviso de requisição HTTPS não verificada
requests.packages.urllib3.disable_warnings(InsecureRequestWarning)

# Configurando o logging
logging.basicConfig(level=logging.DEBUG)

# Dados fornecidos
token_url = "https://api.qrcodes-h.sulcredi.coop.br/oauth/token"
client_id = "00012669317088110000150"
client_secret = " jRjN2FjMjItOTk4NS00MmU5LWI5ZGItN"
crt = "PIX-HMG-CLIENTE.crt"
key = "PIX-HMG-CLIENTE.key"
chave_pix = "258915d9-abaf-49a8-a6c5-24708f18470a"
webhook_url = "https://tprtelecompb.com.br/pix/webhook.php"

# Headers e payload para a requisição de token
headers = {
    'Content-Type': 'application/x-www-form-urlencoded',
}

payload = {
    'grant_type': 'client_credentials',
    'client_id': client_id,
    'client_secret': client_secret,
}

try:
    # Fazendo a requisição para obter o token
    response = requests.post(
        token_url,
        headers=headers,
        data=payload,
        cert=(crt, key),
        verify=False  # Desativa a verificação SSL
    )

    # Verificando a resposta
    if response.status_code in [200, 201]:
        token_data = response.json()
        access_token = token_data.get('access_token')
        logging.debug("Access Token: {}".format(access_token))

        # URL do webhook
        webhook_api_url = "https://api.qrcodes-h.sulcredi.coop.br/webhook/{}".format(chave_pix)

        # Escolher a operação: configurar (PUT) ou deletar (DELETE)
        operation = input("Escolha a operação (configurar/deletar): ").strip().lower()

        if operation == "configurar":
            # Payload do webhook
            webhook_payload = {
                "webhookUrl": webhook_url
            }

            # Headers para a requisição do webhook
            webhook_headers = {
                'Authorization': 'Bearer {}'.format(access_token),
                'Content-Type': 'application/json'
            }

            # Fazendo a requisição PUT para configurar o webhook
            webhook_response = requests.put(
                webhook_api_url,
                headers=webhook_headers,
                data=json.dumps(webhook_payload),
                cert=(crt, key),
                verify=False  # Desativa a verificação SSL
            )

            # Verificando a resposta da configuração do webhook
            if webhook_response.status_code in [200, 201]:
                logging.debug("Webhook configurado com sucesso: {}".format(webhook_response.json()))
                print("Webhook configurado com sucesso.")
            else:
                logging.error("Erro ao configurar webhook: {} - {}".format(webhook_response.status_code, webhook_response.text))
                print("Erro ao configurar webhook: {} - {}".format(webhook_response.status_code, webhook_response.text))

        elif operation == "deletar":
            # Headers para a requisição do webhook
            webhook_headers = {
                'Authorization': 'Bearer {}'.format(access_token),
                'Content-Type': 'application/json'
            }

            # Fazendo a requisição DELETE para remover o webhook
            webhook_response = requests.delete(
                webhook_api_url,
                headers=webhook_headers,
                cert=(crt, key),
                verify=False  # Desativa a verificação SSL
            )

            # Verificando a resposta da remoção do webhook
            if webhook_response.status_code == 204:
                logging.debug("Webhook deletado com sucesso.")
                print("Webhook deletado com sucesso.")
            elif webhook_response.status_code == 403:
                logging.error("Requisição de participante autenticado que viola alguma regra de autorização.")
                print("Requisição de participante autenticado que viola alguma regra de autorização.")
            elif webhook_response.status_code == 404:
                logging.error("Recurso solicitado não foi encontrado.")
                print("Recurso solicitado não foi encontrado.")
            elif webhook_response.status_code == 503:
                logging.error("Serviço não está disponível no momento. Serviço solicitado pode estar em manutenção ou fora da janela de funcionamento.")
                print("Serviço não está disponível no momento. Serviço solicitado pode estar em manutenção ou fora da janela de funcionamento.")
            else:
                logging.error("Erro ao deletar webhook: {} - {}".format(webhook_response.status_code, webhook_response.text))
                print("Erro ao deletar webhook: {} - {}".format(webhook_response.status_code, webhook_response.text))

        else:
            print("Operação inválida. Por favor, escolha 'configurar' ou 'deletar'.")

    else:
        logging.error("Falha ao obter token: {} - {}".format(response.status_code, response.text))
        print("Falha ao obter token: {} - {}".format(response.status_code, response.text))
except requests.exceptions.RequestException as e:
    logging.error("Ocorreu um erro: {}".format(e))
    print("Ocorreu um erro: {}".format(e))
