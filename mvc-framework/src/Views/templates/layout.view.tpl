<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{SITE_TITLE}}</title>
  <link rel="stylesheet" href="{{BASE_DIR}}public/css/style.css">
  {{foreach SiteLinks}}
    <link rel="stylesheet" href="{{~BASE_DIR}}{{this}}">
  {{endfor SiteLinks}}
</head>
<body>
  <header>
    <div class="site-title">{{SITE_TITLE}}</div>
    <nav>
      <ul>
        <li><a href="index.php?page=Index">Home</a></li>
        {{foreach PUBLIC_NAVIGATION}}
          <li><a href="{{nav_url}}">{{nav_label}}</a></li>
        {{endfor PUBLIC_NAVIGATION}}
      </ul>
    </nav>
  </header>

  <main>
    {{{page_content}}}
  </main>

  <footer>
    <p>&copy; {{CURRENT_YEAR}} {{SITE_TITLE}}</p>
  </footer>

  {{foreach EndScripts}}
    <script src="{{~BASE_DIR}}{{this}}"></script>
  {{endfor EndScripts}}
</body>
</html>
