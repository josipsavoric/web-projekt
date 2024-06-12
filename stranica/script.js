document.addEventListener("DOMContentLoaded", function () {
  function setTodaysDate() {
    const today = new Date();
    const options = { weekday: "long", day: "numeric", month: "long" };
    const formattedDate = today.toLocaleDateString("en-US", options);
    document.querySelector(".date").textContent = formattedDate;
  }

  function fetchArticles() {
    fetch("fetch_articles.php")
      .then((response) => response.json())
      .then((data) => {
        updateArticleHolder("sport", data.sports);
        updateArticleHolder("news", data.news);
      })
      .catch((error) => console.error("Error fetching articles:", error));
  }

  function updateArticleHolder(category, articles) {
    const articleHolder = document.querySelector(".articleholder." + category);
    if (!articleHolder) {
      console.error(`No element found with class .articleholder.${category}`);
      return;
    }
    articleHolder.innerHTML = "";
    articles.forEach((article) => {
      const articleElement = document.createElement("article");
      articleElement.innerHTML = `
                <a href="article.php?id=${article.id}" class="article-link">
                    <img src="${article.photo}" alt=""/>
                    <h3>${article.title}</h3>
                    <p>${article.about}</p>
                </a>
            `;
      articleHolder.appendChild(articleElement);
    });
  }

  setTodaysDate();

  fetchArticles();
});
