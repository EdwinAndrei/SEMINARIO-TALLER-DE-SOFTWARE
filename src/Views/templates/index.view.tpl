<section class="hero" style="padding: 3rem 0;">

  {{if isLogged}}
    <h1>¡Bienvenido, {{userName}}!</h1>
    <p style="margin-top:.5rem; color:var(--text-muted);">
      Iniciaste sesión como <strong style="color:var(--toasted);">{{userRol}}</strong>.
    </p>
  {{endif isLogged}}

  {{ifnot isLogged}}
    <h1>¡Bienvenido a {{SITE_TITLE}}!</h1>
    <p style="margin-top:.5rem; color:var(--text-muted);">
      Para ver el menú y realizar un pedido debes iniciar sesión.
    </p>
    <a href="index.php?page=Sec.Login" style="display:inline-block; margin-top:1.5rem; padding:.75rem 2rem; background:var(--tomato); color:#fff; border-radius:2rem; font-weight:700; text-decoration:none;">
      Iniciar Sesión
    </a>
  {{endifnot isLogged}}

</section>