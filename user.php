<?php
$_title = 'Home';
session_start();
if(!isset($_SESSION['user_name'])){
  header('Location: index');
  exit();
}
require_once('components/header.php');
?>

  <nav class="user_nav">
  <a class="active_link" href="user">Profile</a>
    <a href="items">Items</a>
    <a href="user_profile">User Profile</a>
    <a href="logout">Logout</a>
  </nav><br>
  <div class="user_container">
    <h1>Welcome</h1>
    <h1>
    
      <?php
      echo $_SESSION['user_name'];
      ?>
    
    </h1>
    <button class="upload_item_button" onclick="showUploadItemModal()">Upload an item</button>
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
          <input type="text" id="name" name="item_name" value="<?= $_SESSION['item_name']?>"><br>
          <label for="desc">Item description</label><br>
          <input type="text" id="desc" name="item_description" value="<?= $_SESSION['item_description']?>"><br>
          <label for="price">Item price</label><br>
          <input type="number" id="price" name="item_price" value="<?= $_SESSION['item_price']?>"><br>
          <label for="image">Item image</label><br>
          <input type="text" id="image" name="item_image" value="<?= $_SESSION['item_image']?>"><br>
          <button onclick="updateItem()">Update item</button>
        </form>
      </div>
    </div>
    
   
    <div id="items_container"></div>  
  
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
                      <div>${item.item_name}</div>
                      <div>${item.item_description}</div>
                      <div>${item.item_price}</div>
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

        async function updateItem(){           
            const form = event.target.form;
            const itemId = document.querySelector("#update_item_form").dataset.id;
            let formData = new FormData(form);
            formData.append('item_id', itemId);
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