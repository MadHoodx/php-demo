FROM returntocorp/semgrep

WORKDIR /app
COPY . .

CMD ["semgrep","scan","--config",".semgrep.yml","."]
