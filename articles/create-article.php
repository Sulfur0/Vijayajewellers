<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>New article</h3>

<form method="POST" action="../backend/articles/create-article.php">
    <div class="question-group" id="question-group">
        <div class="row">
            <div class="form-group col-md-8">
                <label for="">Name</label>
                <input type="text" class="form-control" id="articleName" name="articleName" required="">           
            </div>
        </div>
    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 


