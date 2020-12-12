<br>
<div class="card">
    <h5 class="card-header">Purchase Order - Create </h5>
    <form method = "POST">
        @csrf
        <div class="card-body">
            <div class="container">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Date</label>
                    <input id="datepicker"  width="100%" />
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Price Total</label>
                    <input type="number" class="form-control" id="po_price_total" value="0" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Cost Total</label>
                    <input type="number" class="form-control" id="po_cost_total" value="0" readonly>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-light" id="addRow">+ Add</button>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table">
                            <thead>
                                <tr>
                                    <th width="30%">Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Cost</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                      </div>
                </div>
            </div>
        </div>
        <div class="card-footer ">
            <button type="button" class="btn btn-primary float-right btn-sm" onclick="save_data()" >Save</button>
        </div>
        <input type="hidden" value="1" id="appendindex">
    </form>
</div>

<script>
  
    $('#table').on('click', '.del' ,function(){
        $(this).closest('tr').remove();
        total_all()
      });

    $('#addRow').on('click',function(){
       
        var inx = $('#appendindex').val();
        $('#appendindex').val(parseInt(inx)+1);
        getItem(inx)

        $('#table').append('<tr>'
                +'<td>'
                    +'<select  id="items_'+inx+'" class="form-control" onchange="passing_valriable('+inx+',this.value)">'
                       +' <option value=""> -- select item --  </option>'
                    +'</select>'
                +'</td>'
                +'<td>'
                    +'<input type="number" class="form-control" value="0" min="1" id="quantity_'+inx+'" >'
                +'</td>'
                +'<td>'
                    +'<input type="number" class="form-control price" id="price_'+inx+'" readonly>'
                +'</td>'
                +'<td>'
                        +'<input type="number" class="form-control" id="cost_'+inx+'" readonly>'
                +'</td>'
                +'<td>'
                    +'<a  class="del"><i class="fas fa-trash"></i></a> '
                +'</td>'
            +'</tr>'    
        )
    })

    function getItem(id){
        var url_item = "{{ url('api/items') }}";
        var option  = '<option value=""> -- select item --  </option>'

        $.ajax({  
            type: "GET",
            url: url_item,       
            success: function (data) {
                data['items'].forEach(function(item) {
                    option += "<option value='"+item.id+"'>"+item.name+"</option>"; 
                });
                $('#items_'+id).html(option);
            }
        });
    }

    function passing_valriable(id,val){
        var url_item_show = "{{ url('api/items-show/') }}/"+val;
        var price_header = 0;
        $.ajax({  
            type: "GET",
            url: url_item_show,       
            success: function (data) {
                $('#price_'+id).val(data.items.price);
                $('#cost_'+id).val(data.items.cost);
                total_all()
            }
        });
    }

    function total_all(){
        var total_header  = 0;
        var cost_header  = 0;
        var counter = $('#appendindex').val();

        for (var i = 1; i < counter; i++) {
            total_detail = $('#price_'+i).val();
            cost_detail = $('#cost_'+i).val();

            if(typeof total_detail !== 'undefined' || typeof cost_detail !== 'undefined'){
                total_header += parseInt(total_detail);
                cost_header += parseInt(cost_detail);
            }
          
        }
        $('#po_price_total').val(total_header)
        $('#po_cost_total').val(cost_header)
    }

    function save_data(){
        var date = $('#datepicker').val();
        var total_header = $('#po_price_total').val();
        var cost_header = $('#po_cost_total').val();
        var save_data_po = "{{ url('/api/create-new/po') }}";
        var counter = $('#appendindex').val();
        var item_det = [];
        var qty_det = [];
        var price_det = [];
        var cost_det = [];
        for (var i = 1; i < counter; i++) {
            item_detail = $('#items_'+i).val();
            qty_detail = $('#quantity_'+i).val();
            total_detail = $('#price_'+i).val();
            cost_detail = $('#cost_'+i).val();
            
            item_det.push(parseInt(item_detail))
            qty_det.push(parseInt(qty_detail))
            price_det.push(parseInt(total_detail))
            cost_det.push( parseInt(cost_detail))
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({  
            type: "POST",
            url: save_data_po,
            data:  { date : date, total_header : total_header, cost_header:cost_header , items :item_det, qty :qty_det, price:price_det, cost : cost_det},
            dataType: 'JSON',       
            success: function (data) {
                toastr.success('Success Created Purchase Orders');
                setTimeout(function(){ 
                    var url = "{{ url('/') }}"
                    window.location.href = url;
                }, 3000);
            }
        }); 
    }

    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });


</script>
