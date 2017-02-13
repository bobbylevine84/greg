<div class="box-body">
  {{ Form::open( array('id' => 'frmList', 'route' => ['masterdata.updatecarrierfeature'], 'method' => 'post') ) }}
    <table class="table table-bordered table-striped">
      <tr>
        <th width="90%">Feature Name</th>
        <th width="10%">Action</th>
      </tr>

      <?php $pageerrors = Session::get('formerrors'); ?>

      @foreach($records as $k => $r)
      <tr>

        <td>
          {{ Form::hidden('keys['.$k.']', $r->_id) }}
          {{ Form::text('records['.$k.'][name]', $r->name, ['id' => 'name'.$k, 'placeholder' => 'Region Name', 'class' => 'form-control validate[required]']) }}
          @if(isset($pageerrors) && isset($pageerrors[$k]) && isset($pageerrors[$k]['name']))
            <span class="validation-error">{{ $pageerrors[$k]['name'] }}</span>
          @endif
        </td>

        <td>
          <span class="glyphicon glyphicon-trash icon-action red" onclick="javascript:confirmAction('{{ URL::route('masterdata.destroycarrierfeature', [ $r->_id, $page ] ) }}', 'Delete this record?')" title="Delete"></span>
        </td>
      </tr>
      @endforeach

    </table>

    <div class="box-footer clearfix">
      <input value=" Save " name="btnSave" class="btn btn-primary" type="submit" /> &nbsp; 
      <div class="pagination pagination-sm no-margin pull-right">
        {{ $records->links() }}
      </div>
    </div>
    <input type="hidden" name="page" value="{{ $page }}" />
  {{ Form::close() }}
</div><!-- /.box-body -->
