const showMore = document.querySelector("a#show-more");

if (showMore) {
  showMore.addEventListener("click", function (e) {
    e.preventDefault();
    (async () => {
      const response = await fetch("/fetchall", {
        method: "GET",
      });
      const data = await response.text();
      document.querySelector("#signatures p").innerHTML = data;
      document.querySelector("div#signatures-blind").remove();
    })();
  });
}
