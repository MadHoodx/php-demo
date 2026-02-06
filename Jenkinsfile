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
        echo "=============================================="
        echo "       SCANNING FOR VULNERABILITIES...        "
        echo "=============================================="
        echo ""
        echo "Files to scan:"
        ls -la src/
        echo ""
        echo "Starting security scan..."
        echo ""

        docker run --rm \
          --volumes-from jenkins \
          -w "$PWD" \
          returntocorp/semgrep:latest \
          semgrep scan --config .semgrep.yml . --json-output semgrep.json --verbose || true
        '''
      }
    }

    stage('Security Report') {
      steps {
        sh '''
        echo "=============================================="
        echo "          SECURITY SCAN RESULTS               "
        echo "=============================================="

        if [ -f semgrep.json ]; then
          docker run --rm \
            --volumes-from jenkins \
            -w "$PWD" \
            python:3-alpine python3 -c "
import json

with open('semgrep.json') as f:
    data = json.load(f)

results = data.get('results', [])
print(f'\\nTotal vulnerabilities found: {len(results)}\\n')

if results:
    print('DETAILED FINDINGS:')
    print('-' * 50)
    for i, r in enumerate(results, 1):
        path = r.get('path', 'unknown')
        line = r.get('start', {}).get('line', '?')
        rule = r.get('check_id', 'unknown')
        msg = r.get('extra', {}).get('message', 'No message')
        severity = r.get('extra', {}).get('severity', 'UNKNOWN')
        print(f'')
        print(f'[{i}] {severity}: {rule}')
        print(f'    File: {path}:{line}')
        print(f'    Message: {msg}')
    print('')
    print('-' * 50)
    print('')
    print('SUMMARY BY TYPE:')
    from collections import Counter
    types = Counter(r.get('check_id') for r in results)
    for rule, count in types.most_common():
        print(f'  {count}x {rule}')
print('')
"
        fi
        echo "=============================================="
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
