  <div class="row">
    <div class="col-md-12">

      <!-- SOME MODAL CONTENT VIA iFRAME :) AND OOPS, THE DETAILS ARE FOR {{ $pid }} -->

      <!-- list table -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">List</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped">
            <tr>
              <th width="20%" class="" data-field="tbl_template.tmpl_name">User</th>
              <th width="20%" class="" data-field="tbl_template.tmpl_name">Date/Time</th>
              <th width="20%" class="" data-field="tbl_template.tmpl_name">Vendor</th>
              <th width="15%" class="" data-field="tbl_template.tmpl_name">Model</th>
              <th width="13%" class="" data-field="tbl_template.tmpl_name">Serial</th>
              <th width="12%" class="" data-field="tbl_template.tmpl_name">IP Address</th>
            </tr>

            @if($records)
              @foreach($records as $k => $r)
                <tr>
                  <td>{{ $r->user }}</td>
                  <td>{{ $r->dt }}</td>
                  <td>{{ $r->vendor }}</td>
                  <td>{{ $r->model }}</td>
                  <td>{{ $r->serial }}</td>
                  <td>{{ $r->depips }}</td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="4">No deployments found.</td>
              </tr>
            @endif

          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
      </div><!-- /.box / list table -->


    </div>
  </div>