Para instalar o integrador do modobank, deve realizar alguns procedimentos.


Verifique a versão do seu mk auth se o mesmo é 18 ou acima.

pode pegar o codigo no github:


se utilizar a versão abaixo da 20, você tera que baixar o que utiliza o .php, ja as demais versões já estão na versão .hhvm



Após isso, verifique a versão do seu python, geralmente versões 18 até 19 utilizam o python3.5
então você vai baixar esse arquivo.

******************************************************************************
versão que utiliza python 3.5
curl https://bootstrap.pypa.io/pip/3.5/get-pip.py -o get-pip.py
python3.5 get-pip.py
e aguarde terminar a instalação.

após ele terminar de instalar, chamar os seguintes comando:
pip install request qrcode



versão que utiliza python 3.7
curl https://bootstrap.pypa.io/pip/3.7/get-pip.py -o get-pip.py
python3.7 get-pip.py
e aguarde terminar a instalação.

após ele terminar de instalar, chamar os seguintes comando:
pip3 install request qrcode

********************************************************************************


baixar o arquivo .zip 


e extrair dentro da /var/www/
após extrair, dar os seguintes comandos:

chmod 777 /var/www/pix/gera.py

chmod 777 /var/www/pix/img

chmod 777 /var/www/pix/web.py




após preencher, va na pasta do pix e execute o seguinte comando.
python3.5 web.py

para versões que utilizam python3.7
python3.7 web.py

após rodar ele configurou seu webhook para receber os pix.


PARA UTILIZAR É SIMPLES:
BASTA CRIAR UMA CONTA DO TIPO BOLETO PROPRIO DO PROVEDOR E POR O NOME DE "modobank" e salvar.
ai você gera os boletos e em seguida vai Após isso, entrar na sua integração : http://seumkauth/pix/admin, o login e senha é o que voce utiliza pra logar no http://mkauth/admin
após logado, ir na opção configurar API e preencher os dados.

e procura pela opção de gerar boleto e procura pelo nome do cliente e busca, após achar, click no botão gerar boleto.
