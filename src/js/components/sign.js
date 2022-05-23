const signupForm = document.querySelector("form#sign-form");

if (signupForm) {
  signupForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = {
      fname: signupForm.querySelector("input[name='fname']").value,
      lname: signupForm.querySelector("input[name='lname']").value,
      email: signupForm.querySelector("input[name='email']").value,
      plz: signupForm.querySelector("input[name='plz']").value,
      city: signupForm.querySelector("input[name='city']").value,
      orga: signupForm.querySelector("input[name='orga']").value,
      optin: signupForm.querySelector("input[name='optin']").checked,
      public: signupForm.querySelector("input[name='public']").checked,
      uuid: signupForm.querySelector("input[name='uuid']").value,
      userdata: signupForm.querySelector("input[name='userdata']").value,
    };
    console.log(formData);
    (async () => {
      const rawResponse = await fetch("/add", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });
      const content = await rawResponse.json();
      console.log(content);
      document.querySelector("span#response-message").innerText =
        content.message;
      document
        .querySelector("#message-container")
        .classList.add(content.status);
      document
        .querySelector("#message-container")
        .scrollIntoView({ behavior: "smooth" });
      if (content.status === "success") {
        signupForm.remove();
        document.getElementById("luke-mobi-container").style.display = "block";
      }
    })();
  });
}
