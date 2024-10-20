# Utiliser l'image officielle Python
FROM python:3.9-slim

# Définir le répertoire de travail à l'intérieur du conteneur
WORKDIR /app

# Installer les dépendances système pour MySQL
RUN apt-get update && \
    apt-get install -y default-libmysqlclient-dev build-essential && \
    rm -rf /var/lib/apt/lists/*

# Installer le package mysql-connector-python directement avec pip
RUN pip install --no-cache-dir mysql-connector-python

# Copier le reste du code dans le répertoire de travail du conteneur
COPY . .

# Spécifier la commande par défaut pour exécuter le script Python
CMD ["python", "votre_script.py"]
