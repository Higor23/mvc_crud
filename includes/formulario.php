<main>
    <section>
        <a href="index.php">
            <button class="btn btn-success">Voltar</button>
        </a>
    </section>

    <h2 class="mt-3"><?= TITLE ?></h2>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="">Nome do Produto</label>
            <input type="text" class="form-control" name="nome" value="<?= $obVaga->nome ?>">
        </div>
        <div class="form-group">
            <label for="">Preço</label>
            <input type="text" class="form-control" name="preco" value="<?= $obVaga->preco ?>">
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <textarea class="form-control" id="" cols="30" rows="10" name="descricao"><?= $obVaga->descricao ?></textarea>
        </div>

        <div class="form-group">
            <label for="">Status</label>

            <div>
                <div class="form-check form-check-inline">
                    <label for="" class="form-control">
                        <input type="radio" name="status" value="s" checked>Ativo
                    </label>

                </div>
                <div class="form-check form-check-inline">
                    <label for="" class="form-control">
                        <input type="radio" name="status" value="n" <?= $obVaga->status == 'n' ? 'checked' : '' ?>> Inativo
                    </label>
                </div>
                <div>
                <br><br>
                    <label for="">Arquivo</label>
                    <input type="file" name="imagem">
                    <br><br>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Enviar</button>
        </div>

    </form>
</main>