<?php
$_title = 'Home';
session_start();
if(!isset($_SESSION['user_name'])){
  header('Location: index');
  exit();
}
require_once(__DIR__.'/private/tsv-parser.php');
require_once('components/header.php');
?>

  <nav class="nav">
    <div></div>
    <div class="nav_logo">
      <img src="assets/logo.svg" alt="logo">
    </div>
    <div class="menulinks">
      <a class="active_link" href="user">Home</a>
      <a href="user_profile">Profile</a>
      <a href="logout">Logout</a>
    </div>
  </nav>
  <div class="user_container">
    <h1>
        Welcome, <?php echo $_SESSION['user_name']; ?>
    </h1>
    <div class="upload_item_button" onclick="showUploadItemModal()"><p>Upload an item</p></div>
    <div class="modal_container">
      <div class="upload_item_modal">
        <div class="close_upload_item_modal">X</div>
        <h3>Upload an item</h3>
        <form id="upload_item_form" onsubmit="return false">
          <label for="name">Item name</label><br>
          <input type="text" id="name" name="item_name"><br>
          <label for="desc">Item description</label><br>
          <input type="text" id="desc" name="item_description"><br>
          <label for="price">Item price</label><br>
          <input type="number" id="price" name="item_price"><br>
          <label for="image">Item image</label><br>
          <input type="text" id="image" name="item_image"><br>
          <button onclick="uploadItem()">Upload item</button>
        </form>
      </div>
    </div>
    <div class="modal_container">
      <div class="update_item_modal">
        <div class="close_update_item_modal">X</div>
        <h3>Update item</h3>
        <form id="update_item_form" onsubmit="return false">
          <label for="name">Item name</label><br>
          <input type="text" id="update_name" name="item_name" value="<?= $_SESSION['item_name']?>"><br>
          <label for="desc">Item description</label><br>
          <input type="text" id="update_desc" name="item_description" value="<?= $_SESSION['item_description']?>"><br>
          <label for="price">Item price</label><br>
          <input type="number" id="update_price" name="item_price" value="<?= $_SESSION['item_price']?>"><br>
          <label for="image">Item image</label><br>
          <input type="text" id="update_image" name="item_image" value="<?= $_SESSION['item_image']?>"><br>
          <button onclick="updateItem()">Update item</button>
        </form>
      </div>
    </div>
    
   <h2>Own Items</h2>
    <div id="items_container">
    </div>
    <h2>Other Items</h2>
    <div id="other_items_container">

      <?php

        $data = json_decode(file_get_contents("otherItems.txt"));

        foreach($data as $item){
            echo "<div class='item' data-id='{$item->id}'>
                    <div class='item_image'>
                        <img src='https://coderspage.com/2021-F-Web-Dev-Images/{$item->image}' />
                    </div>
                    <div class='item_info'>
                        <h4>{$item->title}</h4>
                        <p>{$item->description}</p>
                        <p>{$item->price} DKK</p>
                        
                    </div>
                </div>";
          }
        ?>
    </div>        
  </div>
  <script>
    let modalContainers = document.querySelectorAll(".modal_container");
    // console.log("modalContainers", modalContainers);
    getItems()
    async function getItems(){
        let itemsContainer = document.querySelector("#items_container");
        itemsContainer.innerHTML = "";

        const conn = await fetch("apis/api-get-items", {
            method: "POST"
        })
        const res = await conn.json()
        console.log("items", res);
        if(conn.ok){
            res.forEach((item) =>(
              document.querySelector("#items_container").insertAdjacentHTML("afterbegin", 
            `<div class="item" data-id="${item.item_id}">
                <div class='item_image'>
                    <img src='https://coderspage.com/2021-F-Web-Dev-Images/${item.item_image}' />
                </div>
                <div class="delete_item_button" onclick="deleteItem()">🗑️</div>
                <div class='item_info'>
                  <div class="edit_item_button" onclick="showUpdateItemModal()">🖊️</div>
                  <h4>${item.item_name}</h4>
                  <p>${item.item_description}</p>
                  <p>${item.item_price} DKK</p>
                </div>
            </div>`)
            ))
        }
    }

    //Open Upload Item modal
    function showUploadItemModal(){
      let closeUploadItemModal = document.querySelector(".close_upload_item_modal");
      modalContainers[0].style.display = "flex";
      closeUploadItemModal.addEventListener("click",() => {
        modalContainers[0].style.display = "none";
      });
      
    }

    //Upload item
    async function uploadItem(){
        const form = event.target.form;
        const itemName = document.querySelector("#name").value;
        const itemDesc = document.querySelector("#desc").value;
        const itemPrice = document.querySelector("#price").value;
        const itemImage = document.querySelector("#image").value;
        modalContainers[0].style.display = "none";

        const conn = await fetch("apis/api-upload-item",{
            method: "POST",
            body: new FormData(form)
        })
        const res = await conn.text()
        
        if(conn.ok){
            document.querySelector("#items_container").insertAdjacentHTML("afterbegin", 
            `<div class="item" data-id="${res}">
                <div class='item_image'>
                    <img src='https://coderspage.com/2021-F-Web-Dev-Images/${itemImage}' />
                </div>
                <div class="delete_item_button" onclick="deleteItem()">🗑️</div>
                <div class='item_info'>
                  <div class="edit_item_button" onclick="showUpdateItemModal()">🖊️</div>
                  <div>${itemName}</div>
                  <div>${itemDesc}</div>
                  <div>${itemPrice}</div>
                </div>
            </div>`)
        }
      }

    //Open Update Item modal
    async function showUpdateItemModal(){
      
      const item = event.target.parentNode.parentNode;
      const itemId = item.dataset.id
      let formData = new FormData();
      formData.append('item_id', itemId);

      let closeUpdateItemModal = document.querySelector(".close_update_item_modal");
      modalContainers[1].style.display = "flex";
      closeUpdateItemModal.addEventListener("click",() => {
        console.log("close modal");
        modalContainers[1].style.display = "none";
      });
        const conn = await fetch("apis/api-get-item", {
            method: "POST",
            body: formData
        });
        const res = await conn.json()
        document.querySelector("#update_item_form").dataset.id = itemId;
        
    
      
    }

    //Update Item
    async function updateItem(){           
        const form = event.target.form;
        const itemId = document.querySelector("#update_item_form").dataset.id;
        let formData = new FormData(form);
        formData.append('item_id', itemId);
        const itemName = document.querySelector("#update_name").value;
        const itemDesc = document.querySelector("#update_desc").value;
        const itemPrice = document.querySelector("#update_price").value;
        const itemImage = document.querySelector("#update_image").value;
        modalContainers[1].style.display = "none";
        // console.log(formData.values, itemId);

        const conn = await fetch("apis/api-update-item", {
            method: "POST",
            body: formData
        })
        const res = await conn.text()
        console.log(res);
        getItems();
    }
    
    //Delete Item
    async function deleteItem(){
        const item = event.target.parentNode;
        const id = item.getAttribute('data-id');
        console.log("id delete", id);
        let formData = new FormData();
        formData.append('item_id', id);

        const conn = await fetch("apis/api-delete-item", {
            method: "POST",
            body: formData
        })
        const res = await conn.text()
        item.remove();
    }
  </script>
  <?php
  require_once('components/footer.php');
  ?>   