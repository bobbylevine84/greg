<!-- set counter -->
<?php $ckounter = 0; ?>

<!-- loop for all features -->
@foreach($records as $r)

  <?php $fld  = $r->ft_type == 'Text-area' ? 'txtvalue' : ( $r->ft_data_type == 'Text' ? 'varvalue' : 'decvalue' ); ?>
  <?php $fld2 = $r->ft_data_type == 'Text' ? 'varvalue2' : 'decvalue2'; ?>

  <?php $ft_id = isset($r->ft_id) && !empty($r->ft_id) ? $r->ft_id : $r->_id; ?>

  {{ Form::hidden('vmfkeys['.$r->ft_fld_name . $ft_fld_part.'][ftid]', $ft_id ) }}
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
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , $r->{$fld}, [ 'id' => 'start_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'Start '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>End &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' , $r->{$fld2}, [ 'id' => 'end_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'End '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <?php $ckounter = 2; ?>

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
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , $r->{$fld}, [ 'id' => 'start_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'Start '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label>End &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' , $r->{$fld2}, [ 'id' => 'end_'.$r->ft_fld_name . $ft_fld_part, 'placeholder' => 'End '.$r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld2.']' }}" class="validation-error hideme"></span>
      </div>
    </div>

    <?php $ckounter = 2; ?>

  @endif
  <!-- / if ip range -->

  <!-- if text-box -->
  @if( $r->ft_type == 'Text-box' )
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , $r->{$fld}, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'placeholder' => $r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $ckounter++; ?>
  @endif
  <!-- / if text-box -->

  <!-- if ip -->
  @if( $r->ft_type == 'IP' )

    <?php $fld  = 'decvalue'; ?>

    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::text( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , $r->{$fld}, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'placeholder' => $r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $ckounter++; ?>
  @endif
  <!-- / if ip -->

  <!-- if drop-down -->
  @if( $r->ft_type == 'Drop-down' )

    <?php $options = explode(",", $r->ft_values); ?>
    <?php $options = array_combine($options, $options) ; ?>

    <div class="col-md-6">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::select( 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' , $options, $r->{$fld}, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'class' => 'form-control' ] ) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.']['.$fld.']' }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $ckounter++; ?>
  @endif
  <!-- / if drop-down -->

  <!-- if text-area -->
  @if( $r->ft_type == 'Text-area' )
    <div class="col-md-12">
      <div class="form-group">
        <label>{{ $r->ft_label . $ft_lbl_part }} &nbsp; <small></small></label>
          {{ Form::textarea( 'vmf['.$r->ft_fld_name . $ft_fld_part.'][txtvalue]' , $r->{$fld}, [ 'id' => $r->ft_fld_name . $ft_fld_part, 'rows' => '3', 'placeholder' => $r->ft_label . $ft_lbl_part, 'class' => 'form-control' ]) }}
          <span name="emsg-{{ 'vmf['.$r->ft_fld_name . $ft_fld_part.'][txtvalue]'  }}" class="validation-error hideme"></span>
      </div>
    </div>
    <?php $ckounter = 2; ?>
  @endif
  <!-- / if text-area -->


  @if($ckounter % 2 == 0)
	<!-- <div class="clr"></div> -->
  @endif

@endforeach
<!-- / loop for all features -->