// function to display image preview on edit pages
imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      profilePic.src = URL.createObjectURL(file)
    }
  }

  