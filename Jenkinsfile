pipeline {
  agent any

  stages {

    stage('Checkout Code') {
      steps {
        checkout scm
      }
    }

    stage('Semgrep Scan') {
      steps {
        sh '''
          docker run --rm \
          -v $(pwd):/app \
          returntocorp/semgrep \
          semgrep scan --config /app/.semgrep.yml /app
        '''
      }
    }

  }
}
