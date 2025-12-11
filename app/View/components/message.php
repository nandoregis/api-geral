<div id="container-message" class="container-message {@status}">

    <div id="box-message" class="box-message">
        <p>{@message}</p>
    </div>

    <script>
        const boxMessage = document.getElementById('box-message');
    
        boxMessage.addEventListener('click', () => {
            boxMessage.parentElement.remove();
        });
    </script>
</div>
