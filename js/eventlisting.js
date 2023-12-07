//Displays the user uploaded image to the event listing form
const image_input = document.querySelector("#image_input");
var upload_image = "";

image_input.addEventListener("change", function(){
    console.log(image_input.value);
    const reader = new FileReader();
    reader.addEventListener("load", () => {
        uploaded_image = reader.result;
        document.querySelector("#display_image").style.backgroundImage = `url(${uploaded_image})`;
    });
    reader.readAsDataURL(this.files[0]);
})