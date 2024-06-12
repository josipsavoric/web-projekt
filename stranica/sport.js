document.addEventListener("DOMContentLoaded", function () {
  function setTodaysDate() {
    const today = new Date();
    const options = { weekday: "long", day: "numeric", month: "long" };
    const formattedDate = today.toLocaleDateString("en-US", options);
    document.querySelector(".date").textContent = formattedDate;
  }

  function fetchArticles() {
    fetch("getsport.php")
      .then((response) => response.json())
      .then((data) => {
        updateArticleHolder("sport", data);
      })
      .catch((error) =>
        console.error("Error fetching sports articles:", error)
      );
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
                <img src="${article.photo}" alt=""/>
                <h3>${article.title}</h3>
                <p>${article.about}</p>
            `;
      articleHolder.appendChild(articleElement);
    });
  }

  setTodaysDate();

  fetchArticles();
});
