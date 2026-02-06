FROM returntocorp/semgrep:latest

WORKDIR /app

ENTRYPOINT ["semgrep"]
