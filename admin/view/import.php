<div class="wrap coursepress_wrapper coursepress-import">
	<h2><?php esc_html_e( 'Importieren', 'cp' ); ?></h2>
	<p class="description page-tagline">
		<?php esc_html_e( 'Lade Deine exportierten Kurse hier hoch, um sie zu importieren.', 'cp' ); ?>
	</p>

	<form method="post" enctype="multipart/form-data" class="has-disabled">
		<?php wp_nonce_field( 'coursepress_import', 'coursepress_import' ); ?>
		<p>
			<input type="file" name="import" class="input-key" />
		</p>
		<h3><?php esc_html_e( 'Importiere Optionen', 'cp' ); ?></h3>
		<div>
			<label>
				<input type="checkbox" name="coursepress[replace]" value="1" />
				<?php esc_html_e( 'Kurs ersetzen, falls vorhanden.', 'cp' ); ?>
			</label>
			<p class="description">
				<?php esc_html_e( 'Kurse mit demselben Titel werden automatisch durch den neuen ersetzt.', 'cp' ); ?>
			</p>
		</div><br />
		<div>
			<label>
				<input type="checkbox" name="coursepress[students]" class="input-requiredby" value="1" />
				<?php esc_html_e( 'Schüler einbeziehen', 'cp' ); ?>
			</label>
			<p class="description">
				<?php esc_html_e( 'Die Schülerliste muss ebenfalls in deinem Export enthalten sein, damit dies funktioniert.', 'cp' ); ?>
			</p>
		</div><br />
		<div>
			<label>
				<input type="checkbox" name="coursepress[comments]" data-required-imput="coursepress[students]" disabled="disabled" value="1" />
				<?php esc_html_e( 'Thread/Kommentare einbeziehen', 'cp' ); ?>
			</label>
			<p class="description">
				<?php esc_html_e( 'Die Kommentarliste muss ebenfalls in deinem Export enthalten sein, damit dies funktioniert.', 'cp' ); ?>
			</p>
		</div>
		<div class="cp-submit">
			<?php submit_button( __( 'Datei hochladen und importieren', 'cp' ), 'button-primary disabled' ); ?>
		</div>
	</form>
</div>