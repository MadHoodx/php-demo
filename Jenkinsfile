pipeline {
  agent any

  stages {

    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('Semgrep Scan') {
      steps {
        sh '''
        docker run --rm \
          -v "$PWD:/app" \
          returntocorp/semgrep:latest \
          semgrep scan --config /app/.semgrep.yml /app
        '''
      }
    }
  }
}
