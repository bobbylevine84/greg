<!-- set counter -->
<?php $kounter = 0; ?>

{{ Form::hidden('vmodel', '0' ) }}

<!-- loop for all features -->
@foreach($records as $r)

@if( $r->hasChildren() )
	<div class="clr"></div>
	<div class="col-md-12">
		<div class="box box-solid box-default family-wrapper">
@endif

  <?php $fld  = $r->ft_type == 'Text-area' ? 'txtvalue' : ( $r->ft_data_type == 'Text' ? 'varvalue' : 'decvalue' ); ?>
  <?php $fld2 = $r->ft_data_type == 'Text' ? 'varvalue2' : 'decvalue2'; ?>

  {{ Form::hidden('vmfkeys['.$r->ft_fld_name . $ft_fld_part.'][ftid]', $r->_id, [ 'class' => 'mvfid_' . $r->_id ] ) }}
  {{ Form::hidden('vmfkeys['.$r->ft_fld_name . $ft_fld_part.'][label]', $r->ft_label . $ft_lbl_part ) }}
  {{ Form::hidden('vmfkeys['.$r->ft_fld_name . $ft_fld_part.'][tftid]', 0 ) }}

  <!-- if range -->
  @if( $r->ft_type == 'Range' )

    <div class="clr"></div>

    <div class="col-md-12"><h4>{{ $r->ft_label . $ft_lbl_part }} <small>(enter range)</small></h4></div>
    <br/>
    <br/>

    <div class="col-md-6">
      <div class="form-group">
        <label>Start &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , null, [ 'id' => 'start_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'Start '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>End &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' , null, [ 'id' => 'end_'.$r->ft_fld_name, 'placeholder' => 'End '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <?php $kounter = 2; ?>

  @endif
  <!-- / if range -->

  <!-- if ip range -->
  @if( $r->ft_type == 'IP Range' )

    <?php $fld  = 'decvalue'; ?>
    <?php $fld2 = 'decvalue2'; ?>

    <div class="clr"></div>

    <div class="col-md-12"><h4>{{ $r->ft_label . $ft_lbl_part }} <small>(enter range)</small></h4></div>
    <br/>
    <br/>

    <div class="col-md-6">
      <div class="form-group">
        <label>Start &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , null, [ 'id' => 'start_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'Start '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>End &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' , null, [ 'id' => 'end_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'End '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <?php $kounter = 2; ?>

  @endif
  <!-- / if ip range -->

  <!-- if text-box -->
  @if( $r->ft_type == 'Text-box' )
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , null, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'placeholder' => $r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $kounter++; ?>
  @endif
  <!-- / if text-box -->

  <!-- if ip -->
  @if( $r->ft_type == 'IP' )

    <?php $fld  = 'decvalue'; ?>

    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , null, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'placeholder' => $r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $kounter++; ?>
  @endif
  <!-- / if ip -->

  <!-- if drop-down -->
  @if( $r->ft_type == 'Drop-down' )

    <?php $options = explode(",", $r->ft_values); ?>
    <?php $options = array_combine($options, $options) ; ?>

    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::select( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , $options, null, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'class' => 'form-control' ] ) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $kounter++; ?>
  @endif
  <!-- / if drop-down -->

  <!-- if text-area -->
  @if( $r->ft_type == 'Text-area' )
    <div class="col-md-12">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::textarea( 'vmf['.$r->ft_fld_name . $ft_fld_part.'][txtvalue]' , null, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'rows' => '3', 'placeholder' => $r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.'][txtvalue]'  }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $kounter = 2; ?>
  @endif
  <!-- / if text-area -->

  <!-- if label -->
  @if( $r->ft_type == 'Label' )

    <div class="clr"></div>

    <div class="col-md-12"><h4>{{ $r->ft_label . $ft_lbl_part }}</h4></div>
    <br/>
    <br/>

    <?php $kounter = 2; ?>
  @endif
  <!-- / if label -->

  <!-- getting child -->
  @if( $r->hasChildren() )

  	{{ View::make('templates._vmfchildform', [ 'records' => $r->children(), 'ft_lbl_part' => $ft_lbl_part, 'ft_fld_part' => $ft_fld_part ] ) }}

    <?php $kounter = 2; ?>

  @endif
  <!-- / getting child -->

  @if($kounter % 2 == 0)
    <div class="clr"></div>
  @endif

@if( $r->hasChildren() )
		</div>
		<div class="clr"></div>
	</div>
@endif

@endforeach
<!-- / loop for all features -->