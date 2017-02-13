<!-- set counter -->
<?php $kounter = 0; ?>

<!-- loop for all features -->
@foreach($records as $r)

  <?php $fld  = $r->ft_data_type == 'Text' ? 'varvalue' : 'decvalue'; ?>
  <?php $fld2 = $r->ft_data_type == 'Text' ? 'varvalue2' : 'decvalue2'; ?>

  <!-- if range -->
  @if( $r->ft_type == 'Range' || $r->ft_type == 'IP Range' )

    <div class="clr"></div>

    <div class="col-md-12"><h4>{{ $r->ft_label }} <small>(enter range)</small></h4></div>
    {{ Form::hidden('cmfkeys['.$r->ft_fld_name.']', $r->_id ) }}
    <br/>
    <br/>

    <div class="col-md-6">
      <div class="form-group">
        <label>Start &nbsp; <small><span class="fa fa-star red"></span></small></label>
          {{ Form::text( 'cmf['.$r->ft_fld_name.']['.$fld.']' , null, [ 'id' => 'start_'.$r->ft_fld_name, 'placeholder' => 'Start '.$r->ft_label, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'cmf['.$r->ft_fld_name.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>End &nbsp; <small><span class="fa fa-star red"></span></small></label>
          {{ Form::text( 'cmf['.$r->ft_fld_name.']['.$fld2.']' , null, [ 'id' => 'end_'.$r->ft_fld_name, 'placeholder' => 'End '.$r->ft_label, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'cmf['.$r->ft_fld_name.']['.$fld2.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <?php $kounter = 2; ?>

  @endif
  <!-- / if range -->

  <!-- if text-box -->
  @if( $r->ft_type == 'Text-box' || $r->ft_type == 'IP' )
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label }} &nbsp; <small><span class="fa fa-star red"></span></small></label>
          {{ Form::text( 'cmf['.$r->ft_fld_name.']['.$fld.']' , null, [ 'id' => $r->ft_fld_name, 'placeholder' => $r->ft_label, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'cmf['.$r->ft_fld_name.']['.$fld.']' }}" class="validation-error hideme"></span>
          {{ Form::hidden('cmfkeys['.$r->ft_fld_name.']', $r->_id ) }}
      </div>
    </div>
    <?php $kounter++; ?>
  @endif
  <!-- / if text-box -->

  <!-- if drop-down -->
  @if( $r->ft_type == 'Drop-down' )

    <?php $options = explode(",", $r->ft_values); ?>
    <?php $options = array_combine($options, $options) ; ?>

    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label }} &nbsp; <small><span class="fa fa-star red"></span></small></label>
          {{ Form::select( 'cmf['.$r->ft_fld_name.']['.$fld.']' , $options, null, [ 'id' => $r->ft_fld_name, 'class' => 'form-control' ] ) }}
          <span name="emsg-{{ 'cmf['.$r->ft_fld_name.']['.$fld.']' }}" class="validation-error hideme"></span>
          {{ Form::hidden('cmfkeys['.$r->ft_fld_name.']', $r->_id ) }}
      </div>
    </div>
    <?php $kounter++; ?>
  @endif
  <!-- / if drop-down -->

  <!-- if text-area -->
  @if( $r->ft_type == 'Text-area' )
    <div class="col-md-12">
      <div class="form-group">
        <label>{{ $r->ft_label }} &nbsp; <small><span class="fa fa-star red"></span></small></label>
          {{ Form::textarea( 'cmf['.$r->ft_fld_name.'][txtvalue]' , null, [ 'id' => $r->ft_fld_name, 'rows' => '3', 'placeholder' => $r->ft_label, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'cmf['.$r->ft_fld_name.'][txtvalue]'  }}" class="validation-error hideme"></span>
          {{ Form::hidden('cmfkeys['.$r->ft_fld_name.']', $r->_id ) }}
      </div>
    </div>
    <?php $kounter = 2; ?>
  @endif
  <!-- / if text-area -->

  <!-- if label -->
  @if( $r->ft_type == 'Label' )

    <div class="clr"></div>

    <div class="col-md-12"><h4>{{ $r->ft_label }}</h4></div>
    {{ Form::hidden('cmfkeys['.$r->ft_fld_name.']', $r->_id ) }}
    <br/>
    <br/>

    <?php $kounter = 2; ?>
  @endif
  <!-- / if label -->

  <!-- getting child -->
  @if( $r->hasChildren() )

    <div class="clr"></div>

  	{{ View::make('templates._cmfchildform', [ 'records' => $r->children() ] ) }}

    <div class="clr"></div>

    <?php $kounter = 2; ?>

  @endif
  <!-- / getting child -->

  @if($kounter % 2 == 0)
    <div class="clr"></div>
  @endif

@endforeach
<!-- / loop for all features -->
