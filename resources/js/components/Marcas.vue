<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <!-- início do card de listagem de marcas -->
        <card-component titulo="Relação de Marcas">
          <template v-slot:conteudo>
            <table-component></table-component>
          </template>
          <template v-slot:rodape>
            <button type="button" class="btn btn-primary btn-sm float-right">Adicionar</button>
          </template>
        </card-component>
        <!-- final do card de listagem de marcas -->

      </div>
    </div>
  </div>
</template>

<script>

</script>
