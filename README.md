# Very simple TYPO3 extension to update the source_host column of TYPO3 redirects

- Install using composer
- Execute the command with two simple
  arguments `yourPathToTypo3Cli/typo3 typo3-redirects-updater:replace-source-host <from> <to>`

## Example use case

```bash
/var/www/vendor/bin/typo3 typo3-redirects-updater:replace-source-host 'customer.preview.example.org' 'www.customer.at'
```
