import fs from 'node:fs';
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const currentFile = fileURLToPath(import.meta.url);
const repoRoot = path.resolve(path.dirname(currentFile), '..');
const reportDir = path.join(repoRoot, 'artifacts', 'visual', 'report');
const reportIndex = path.join(reportDir, 'index.html');
const resultsFile = path.join(reportDir, 'results.json');
const shouldOpen = process.argv.includes('--open');
const ciMode = process.argv.includes('--ci');

function collectFailedTests(suite, failures = []) {
  for (const childSuite of suite.suites ?? []) {
    collectFailedTests(childSuite, failures);
  }

  for (const spec of suite.specs ?? []) {
    const failedResults = (spec.tests ?? []).filter((test) => test.status !== 'expected');
    if (failedResults.length === 0) {
      continue;
    }

    failures.push({
      title: spec.title,
      file: spec.file,
      projects: failedResults.map((test) => test.projectName).join(', ')
    });
  }

  return failures;
}

console.log(`Visual report: ${reportIndex}`);

if (shouldOpen) {
  const opener = process.platform === 'darwin' ? 'open' : 'xdg-open';
  try {
    execFileSync(opener, [reportIndex], { stdio: 'ignore' });
    console.log(`Opened report with ${opener}.`);
  } catch {
    console.log('Could not open the report automatically. Open the path above manually.');
  }
}

if (!fs.existsSync(resultsFile)) {
  console.log('No JSON results found yet.');
  process.exit(0);
}

const results = JSON.parse(fs.readFileSync(resultsFile, 'utf8'));
const failures = collectFailedTests(results);

if (failures.length === 0) {
  console.log('Visual summary: all checks passed.');
  process.exit(0);
}

if (ciMode) {
  console.log(`VISUAL_REPORT=${reportIndex}`);
  console.log(`VISUAL_FAILURE_COUNT=${failures.length}`);
  for (const failure of failures) {
    console.log(`VISUAL_FAILURE=${failure.projects}|${failure.title}`);
  }
  process.exit(0);
}

console.log('Visual summary: failed pages');
for (const failure of failures) {
  console.log(`- ${failure.title} [${failure.projects}]`);
}
