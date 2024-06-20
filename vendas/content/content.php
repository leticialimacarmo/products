 <div id="content">

   <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

     <form class="form-inline">
       <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
       </button>
     </form>

     <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
       <div class="input-group">
         <input type="text" class="form-control bg-light border-0 small" placeholder="Pesquisar..." aria-label="Search" aria-describedby="basic-addon2">
         <div class="input-group-append">
           <button class="btn btn-primary" type="button">
             <i class="fas fa-search fa-sm"></i>
           </button>
         </div>
       </div>
     </form>

     <ul class="navbar-nav ml-auto">

       <li class="nav-item dropdown no-arrow d-sm-none">
         <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-search fa-fw"></i>
         </a>
         <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
           <form class="form-inline mr-auto w-100 navbar-search">
             <div class="input-group">
               <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
               <div class="input-group-append">
                 <button class="btn btn-primary" type="button">
                   <i class="fas fa-search fa-sm"></i>
                 </button>
               </div>
             </div>
           </form>
         </div>
       </li>

       <div class="topbar-divider d-none d-sm-block"></div>

       <li class="nav-item dropdown no-arrow">
         <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <span class="mr-2 d-none d-lg-inline text-gray-600 small">Letícia Lima</span>
           <img class="img-profile rounded-circle" src="../principal/assets/images/undraw_profile_1.svg">
         </a>
       </li>

     </ul>

   </nav>

   <div class="container-fluid">

     <h1 class="h3 mb-2 text-gray-800">Vendas</h1>
     <br>
     <form>
       <div class="form-row">
         <div class="form-group col-md-6">
           <label class="">Vendedor</label>
           <input type="text" class="form-control" id="vendedor" name="vendedor" placeholder="Adicione o vendedor...">
         </div>
         <div class="form-group col-md-6">
           <label class="">Cliente</label><br>
           <select class="form-select form-control selectpicker" style="height: 800px;" data-live-search="true" id="cliente" name="cliente" placeholder="Selecione o cliente...">
             <option value="">Selecione...</option>
             <option value="a">a</option>
             <option value="b">b</option>
             <option value="c">c</option>
           </select>
         </div>

       </div>
     </form>
     <br>



     <ul class="nav nav-tabs" style="border-bottom: 1px solid #ddd; margin-bottom: 20px;">
       <li class="nav-item">
         <a class="nav-link active" data-toggle="tab" href="#itens" style="padding: 0.5rem 1rem; font-size: 16px;">Itens</a>
       </li>
       <li class="nav-item">
         <a class="nav-link" data-toggle="tab" href="#pagamento" style="padding: 0.5rem 1rem; font-size: 16px;">Pagamento</a>
       </li>
     </ul>

     <div class="tab-content">
       <div class="tab-pane fade show active" id="itens">
         <form id="formCadastro">
           <div class="form-row" style="gap:10px">
             <div class="form-group col-md-3">
               <label class="required">Selecionar Produto</label>
               <select class="form-select form-control selectpicker" style="height: 800px;" data-live-search="true" id="produto" name="produto" placeholder="Selecione o produto...">
                 <option value="">Selecione...</option>
                 <option value="a">a</option>
                 <option value="b">b</option>
                 <option value="c">c</option>
               </select>
             </div>

             <div class="form-group col-md-2">
               <label class="required">Valor Unitário</label>
               <input type="text" class="form-control" id="valorUnitario" name="valorUnitario" placeholder="Adicione o valor unitário...">
             </div>
             <div class="form-group col-md-2">
               <label class="required">Quantidade</label>
               <input type="text" class="form-control" id="quantidade" name="quantidade" placeholder="Adicione a quantidade...">
             </div>
             <div class="form-group col-md-3">
               <label class="required">Subtotal</label>
               <input type="text" class="form-control" id="subtotal" name="subtotal" placeholder="Adicione o subtotal...">
             </div>
             <button type="button" class="btn btn-info btn-sm" id="addItem" style="height:30px; width:30px; margin-top:35px">+ Adicionar</button>
           </div>
         </form>
         <div class="table-responsive">
           <table class="table table-bordered">
             <thead>
               <tr>
                 <th>Id</th>
                 <th>Item</th>
                 <th>Cliente</th>
                 <th>Vendedor</th>
                 <th>Quantidade</th>
                 <th>Valor Unitário</th>
                 <th>Total</th>
                 <th>Operar</th>
               </tr>
             </thead>
             <tbody>

             </tbody>
           </table>
         </div>
       </div>

       <div class="tab-pane fade" id="pagamento">
         <div class="parcelas" style=" gap: 20px; display: flex">
           <div class="form-group col-md-3">
             <label class="required">Número de Parcelas</label>
             <input type="text" class="form-control" id="nParcela" name="nParcela" placeholder="Adicione o numero de parcelas do Produto...">

           </div>
           <div class="form-group col-md-2">
             <label class="required">Data Vencimento</label>
             <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" placeholder="Adicione a data de vencimento da parcela...">

           </div>
           <div class="form-group col-md-2">
             <label class="required">Valor da Parcela</label>
             <input type="text" class="form-control" id="valor_parcela" name="valor_parcela" disabled placeholder="Adicione o valor da parcela...">

           </div>
           <button type="button" class="btn btn-warning btn-sm" id="addParcela" style="height:30px; width:30px; margin-top:35px">+</button>

         </div>


         <div class="table-responsive">
           <table class="table table-bordered">
             <thead>
               <tr>
                 <th>Parcela</th>
                 <th>Valor</th>
                 <th>Data de Vencimento</th>
               </tr>
             </thead>
             <tbody>
             </tbody>
           </table>
         </div>
       </div>
     </div>
   </div>

   <button style="display: flex; margin: auto" type="submit" id="salvar" disabled class="btn btn-success">+ Salvar</button>

 </div>

 </div>


 <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="updateModalLabel">Atualização de Venda</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <form id="formAtualizacao">
           <div class="form-row">
             <div class="fv-row form-group col-md-6">
               <label class="required">Item</label>
               <select class="form-select form-control selectpicker" style="height: 800px;" data-live-search="true" id="produto_update" name="produto_update" placeholder="Selecione o produto...">
                 <option value="">Selecione...</option>
                 <option value="a">a</option>
                 <option value="b">b</option>
                 <option value="c">c</option>
               </select>
             </div>
             <div class="fv-row form-group col-md-6">
               <label class="required">Quantidade</label>
               <input type="text" class="form-control" name="quantidade_update" id="quantidade_update" placeholder="Adicione a quantidade...">
             </div>
           </div>
           <div class="fv-row form-group">
             <label class="required">Valor Unitário</label>
             <input type="text" class="form-control" name="valor_update" id="valor_update" placeholder="Adicione o Valor Unitário...">
           </div>
           <div class="fv-row form-group">
             <label class="required">Subtotal</label>
             <input type="text" class="form-control" name="subtotal_update" id="subtotal_update" placeholder="Adicione o subtotal...">
           </div>


         </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" id="fecha" data-dismiss="modal">Fechar</button>
         <button type="button" class="btn btn-primary" id="update">Salvar</button>
       </div>
     </div>
   </div>
 </div>