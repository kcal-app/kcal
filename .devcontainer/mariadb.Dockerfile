FROM mariadb:10

COPY --chmod=644 create-testing-database.sh /docker-entrypoint-initdb.d/10-create-testing-database.sh
