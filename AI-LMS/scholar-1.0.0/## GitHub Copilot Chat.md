## GitHub Copilot Chat

- Extension Version: 0.25.1 (prod)
- VS Code: vscode/1.98.2
- OS: Windows

## Network

User Settings:
```json
  "github.copilot.advanced.debug.useElectronFetcher": true,
  "github.copilot.advanced.debug.useNodeFetcher": false,
  "github.copilot.advanced.debug.useNodeFetchFetcher": true
```

Connecting to https://api.github.com:
- DNS ipv4 Lookup: 20.207.73.85 (133 ms)
- DNS ipv6 Lookup: Error (13 ms): getaddrinfo ENOTFOUND api.github.com
- Proxy URL: None (8 ms)
- Electron fetch (configured): HTTP 200 (89 ms)
- Node.js https: HTTP 200 (90 ms)
- Node.js fetch: HTTP 200 (302 ms)
- Helix fetch: HTTP 200 (171 ms)

Connecting to https://api.individual.githubcopilot.com/_ping:
- DNS ipv4 Lookup: 140.82.112.22 (15 ms)
- DNS ipv6 Lookup: Error (30 ms): getaddrinfo ENOTFOUND api.individual.githubcopilot.com
- Proxy URL: None (3 ms)
- Electron fetch (configured): HTTP 200 (691 ms)
- Node.js https: HTTP 200 (870 ms)
- Node.js fetch: HTTP 200 (919 ms)
- Helix fetch: HTTP 200 (649 ms)

## Documentation

In corporate networks: [Troubleshooting firewall settings for GitHub Copilot](https://docs.github.com/en/copilot/troubleshooting-github-copilot/troubleshooting-firewall-settings-for-github-copilot).