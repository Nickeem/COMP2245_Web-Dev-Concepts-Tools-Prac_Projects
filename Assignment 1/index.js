/*  DONE BY NICKEEM PAYNE-DEACON    */
function toggleMenu() {
    

    if (window.innerWidth >= 1100) {
        return;
    }
    else {
        if (document.getElementsByClassName("menu-items")[0].style.display == "") {
            document.getElementsByClassName("menu-items")[0].style.display = "block";
        }
        else{
            document.getElementsByClassName("menu-items")[0].style.display = "";
        }
    }
}

function boxAppear(e){
    document.getElementsByClassName("box-image")[0].src = e.target.src;
    document.getElementsByClassName("popup-container")[0].style.display = "block";
    document.getElementsByClassName("popup-box")[0].style.display = "grid";
  }

  function targetBoxAppear(e) {
    console.log(e.target);
    toggleMenu();
    const box_name = (e.target.innerHTML).toLowerCase().replace(/\s+/g, '') + "-box";
    console.log(document.getElementsByClassName(box_name)[0]);
    document.getElementsByClassName("popup-container")[0].style.display = "block";
    document.getElementsByClassName(box_name)[0].style.display = "block";
  }
  
  function closeBox(e) {
    console.log(e);
    e.target.parentNode.parentNode.style.display = "none"; // eg ...-box
    document.getElementsByClassName("popup-container")[0].style.display = "none";
  }
