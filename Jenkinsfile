pipeline {
  agent any

  stages {

    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('SAST - Semgrep Scan') {
      steps {
        sh '''
          docker run --rm \
          -v $(pwd):/src \
          returntocorp/semgrep \
          semgrep --config=auto
        '''
      }
    }
 
  }
}
