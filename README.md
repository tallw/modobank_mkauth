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


Após 
