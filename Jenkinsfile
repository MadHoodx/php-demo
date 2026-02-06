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
          semgrep scan --config .semgrep.yml . --json --output semgrep.json || true
        '''
      }
    }

    stage('Security Report') {
      steps {
        sh '''
        echo "======================================"
        echo "       SECURITY SCAN RESULTS          "
        echo "======================================"

        if [ -f semgrep.json ]; then
          TOTAL=$(cat semgrep.json | grep -o '"check_id"' | wc -l)
          echo ""
          echo "Total vulnerabilities found: $TOTAL"
          echo ""
          echo "Findings by type:"
          cat semgrep.json | grep -o '"check_id":"[^"]*"' | sort | uniq -c | sort -rn
          echo ""
          echo "======================================"
        fi
        '''
      }
    }

    stage('Security Gate') {
      steps {
        sh '''
        if [ -f semgrep.json ]; then
          COUNT=$(cat semgrep.json | grep -o '"check_id"' | wc -l)
          if [ "$COUNT" -gt 0 ]; then
            echo "SECURITY GATE FAILED: Found $COUNT vulnerabilities!"
            echo "Fix the issues above before merging."
            exit 1
          fi
        fi
        echo "SECURITY GATE PASSED: No vulnerabilities found!"
        '''
      }
    }
  }

  post {
    always {
      archiveArtifacts artifacts: 'semgrep.json', allowEmptyArchive: true
    }
    failure {
      echo '❌ Pipeline failed due to security vulnerabilities!'
    }
    success {
      echo '✅ All security checks passed!'
    }
  }
}
