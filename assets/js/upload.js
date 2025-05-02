document.getElementById("fileToUpload").addEventListener("change", (event) => {
  const fileName = event.target.files[0] ? event.target.files[0].name : "No file chosen";
  document.querySelector(".file-name-display").textContent = fileName;
});
