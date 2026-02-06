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
          --volumes-from jenkins \
          -w "$PWD" \
          returntocorp/semgrep:latest \
          semgrep scan --config .semgrep.yml . --error --json --output semgrep.json

        '''
      }
    }
  }
}
