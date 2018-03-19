# how-to-bundle
Step-by-step tutorial how to prepare Symfony bundle

## 1. Prepare repository
Prepare bundle repository in the way you like. You can use Github or local repository.
Be advised that repository need to accessible by your future project.   
With Github wizard you can add README.md and LICENCE

## 2. Clone repository
```bash
git clone https://github.com/kjonski/how-to-bundle.git
```
and open with editor.

## 3. Add `composer.json` file
```yaml
{
    "name": "kjonski/how-to-bundle",
    "type": "symfony-bundle",
    "description": "Step-by-step Symfony bundle tutorial",
    "keywords": ["php", "symfony", "reusable bundle", "tutorial"],
    "license": "MIT",
    "authors": [
        {
            "name": "Karol Jonski",
            "email": "kjonski@pgs-soft.com"
        }
    ]
}
```
commit and push changes.
