        </section>

        <nav class="bottom-nav" aria-label="Main navigation">
          <a class="nav-item <?= $currentPage === "home" ? "active" : "" ?>" href="index.php">
            <span data-lucide="home"></span>
            <span>Home</span>
          </a>
          <a class="nav-item <?= $currentPage === "search" ? "active" : "" ?>" href="search.php">
            <span data-lucide="search"></span>
            <span>Search</span>
          </a>
          <a class="nav-item create-nav <?= $currentPage === "create" ? "active" : "" ?>" href="create.php">
            <span data-lucide="plus"></span>
            <span>Post</span>
          </a>
          <a class="nav-item <?= $currentPage === "nearby" ? "active" : "" ?>" href="nearby.php">
            <span data-lucide="map-pin"></span>
            <span>Places</span>
          </a>
          <a class="nav-item <?= $currentPage === "profile" ? "active" : "" ?>" href="profile.php">
            <span data-lucide="user"></span>
            <span>Me</span>
          </a>
        </nav>
      </main>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script src="app.js"></script>
  </body>
</html>
