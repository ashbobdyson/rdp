@extends('layouts.app')

@section('content')
  <div class="client-area">
      <?php if ( post_password_required( $post ) ) { ?>

        <div class="wrapper-password">
            <h1>Client Area.</h1>
            <?php echo get_the_password_form(); ?>
        </div>

    <?php } else {

       echo 'test';

    } ?>
  </div>
@endsection
