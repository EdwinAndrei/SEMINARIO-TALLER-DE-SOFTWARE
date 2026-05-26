<section>
  <h2>Sign In</h2>

  {{if error}}
  <p class="form-error">{{error}}</p>
  {{endif error}}

  <form method="POST" action="index.php?page=Sec.Login">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" required autofocus>

    <label for="passwd">Password</label>
    <input type="password" id="passwd" name="passwd" required>

    <button type="submit">Sign In</button>
  </form>
</section>
