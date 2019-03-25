<table class="company two-column">
    <tr>
	    <td class="logo" width="50%">
		    <?php
		    if ( BEWPI()->templater()->get_logo_url() ) {
			    printf( '<img src="var:company_logo" style="max-height:100px;"/>' );
		    } else {
			    printf( '<h2>%s</h2>', esc_html( BEWPI()->get_option( 'template', 'company_name' ) ) );
		    }
		    ?>
	    </td>
	    <td class="info" width="50%">
		    <?php echo nl2br( $this->template_options['bewpi_company_address'] ); ?><br/>
		    <?php echo nl2br( $this->template_options['bewpi_company_details'] ); ?>
	    </td>
    </tr>
</table>
