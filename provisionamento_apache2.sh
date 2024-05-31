#!/bin/bash

# Atualizar o servidor
echo "Atualizando o servidor..."
apt-get update -y
apt-get upgrade -y

# Instalar o apache2
echo "Instalando o Apache2..."
apt-get install apache2 -y

# Instalar o unzip
echo "Instalando o unzip..."
apt-get install unzip -y

# Baixar a aplicação no diretório /tmp
echo "Baixando a aplicação..."
cd /tmp
wget https://github.com/denilsonbonatti/linux-site-dio/archive/refs/heads/main.zip

# Descompactar a aplicação
echo "Descompactando a aplicação..."
unzip main.zip

# Copiar os arquivos da aplicação para o diretório padrão do Apache
echo "Copiando os arquivos da aplicação para o diretório padrão do Apache..."
cp -R /tmp/linux-site-dio-main/* /var/www/html/

# Ajustar permissões
echo "Ajustando permissões..."
chown -R www-data:www-data /var/www/html

# Reiniciar o Apache para garantir que todas as alterações sejam aplicadas
echo "Reiniciando o Apache..."
systemctl restart apache2

echo "Provisionamento concluído com sucesso."
