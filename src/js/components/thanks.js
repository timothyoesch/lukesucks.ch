import { Notyf } from "notyf";
import "notyf/notyf.min.css";
const notyf = new Notyf();

if (document.querySelector("#luke-mobi-buttons button")) {
  document.querySelectorAll("#luke-mobi-buttons button").forEach((button) => {
    button.addEventListener("click", function (e) {
      let type = e.target.getAttribute("data-type");
      let text =
        "Hey!\nIch habe gerade einen offenen Brief gegen den Auftritt von Luke Mockridge im Hallenstadion unterschrieben. Täter von sexuellen Übergriffen darf keine Bühne gegeben werden!\nIch wäre dir mega dankbar, wenn du den Brief auch unterschreiben würdest:";
      text = text.replace(/<p>(.*)<\/p>/g, "$1");
      let url = "https://lukesucks.ch/";
      if (type == "whatsapp") {
        window.open(
          `https://api.whatsapp.com/send/?text=${encodeURIComponent(
            text
          )}%0A${encodeURIComponent(url)}`
        );
      } else if (type == "facebook") {
        window.open(
          `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
            url
          )}`
        );
      } else if (type == "twitter") {
        window.open(
          `https://twitter.com/intent/tweet?text=${encodeURIComponent(
            text
          )}%0A${encodeURIComponent(url)}`
        );
      } else if (type == "email") {
        window.open(
          `mailto:?body=${encodeURIComponent(text)}%0A${encodeURIComponent(
            url
          )}`
        );
      } else if (type == "copy") {
        text = text.replace(/<b>(.*)<\/b>/g, "$1");
        text = text.replace(/<strong>(.*)<\/strong>/g, "$1");
        navigator.clipboard.writeText(text + "\n" + url);
        notyf.success("Die Nachricht wurde in die Zwischenablage kopiert!");
      } else if (type == "telegram") {
        text = text.replace(/<b>(.*)<\/b>/g, "**$1**");
        text = text.replace(/<strong>(.*)<\/strong>/g, "**$1**");
        window.open(
          `https://t.me/share/url?url=${encodeURIComponent(
            url
          )}&text=${encodeURIComponent(text)}`
        );
      }
    });
  });
}
