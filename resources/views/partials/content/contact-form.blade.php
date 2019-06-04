<div class="contact-form-wrapper cap-width">
	<?= do_shortcode('[contact-form-7 id="5" title="Contact form 1"]') ?>
	<!--
	<form id="main-form" method="POST" action="https://online.lightbluesoftware.com/api.php" novalidate="novalidate">
		<input type="hidden" name="clientPortalKey" value="ff0318434609c3647b9f5334ffc01abd">
		<input type="hidden" name="formKey" value="">
		<div class="formField">
			<div class="yourName"><input class="formTextInput" type="text" id="yourName" name="yourName"></div>
		</div>
		<div class="formField">
			<h3 class="formFieldHeading">Event Description <span class="formRequired">(required)</span></h3>
			<div class="formFieldExplanatoryTextBeforeInput">Please provide a description of your event</div>
			<input class="formTextInput" type="text" id="ShootTitle" name="ShootTitle" value="" hashadvalue="false">
		</div> 
		<div class="formField">
			<h3 class="formFieldHeading">Shoot Type</h3>
			<select class="formPopupMenu" id="ShootType" name="ShootType">
				<option value="Select a type">Select a type</option>
				<option value="Press">Press</option>
				<option value="Public Relations">Public Relations</option>
				<option value="Weddings">Weddings</option>
				<option value="Workshop">Workshop</option>
			</select>
			<div class="formFieldExplanatoryTextAfterInput">What type of shoot would you like mw to carry out?</div>
		</div> 
		<div class="formField">
			<h3 class="formFieldHeading">Shoot description</h3>
			<textarea class="formTextArea" id="ParagraphText4020A98D530746818ACFCF05774BB02E" name="ParagraphText4020A98D530746818ACFCF05774BB02E" rows="10" hashadvalue="false"></textarea>
			<div class="formFieldExplanatoryTextAfterInput">Let me know any additional information about the shoot</div>
		</div>
		<div class="formField">
			<h3 class="formFieldHeading">Date (dd/mm/yyyy)</h3>
			<div class="formFieldExplanatoryTextBeforeInput">Let me know that date that you would like me to carry out a shoot</div>
			<input class="formDateInput hasDatepicker" type="text" id="ShootDate" name="ShootDate" value=""><img class="ui-datepicker-trigger" src="https://online.lightbluesoftware.com/client-portal/calendarButtonIcon.png" alt="Select date" title="Select date">
		</div> 
		<div class="formField">
			<h3 class="formFieldHeading">Start Time (24-hour time)</h3>
			<input class="formTimeInput ui-timepicker-input" type="text" id="ShootTimeStart" name="ShootTimeStart" value="" placeholder="hh:mm" autocomplete="off">
			<div class="formFieldExplanatoryTextAfterInput">Start time</div>
		</div> 
		<div class="formField">
			<h3 class="formFieldHeading">End Time (24-hour time)</h3>
			<input class="formTimeInput ui-timepicker-input" type="text" id="ShootTimeEnd" name="ShootTimeEnd" value="" placeholder="hh:mm" autocomplete="off">
			<div class="formFieldExplanatoryTextAfterInput">End Time</div>
		</div> 
		<div class="formField">
			<h3 class="formFieldHeading">Location</h3>
			<input class="formTextInput" type="text" id="ShootLocation" name="ShootLocation" value="" hashadvalue="false">
			<div class="formFieldExplanatoryTextAfterInput">Location of event</div>
		</div>  
		<div class="formField">
			<h3 class="formFieldHeading">Referral Source</h3>
			<select class="formPopupMenu" id="ShootReferralSource" name="ShootReferralSource">
				<option value="Google search">Google search</option>
				<option value="Word of Mouth">Word of Mouth</option>
				<option value="Existing customer">Existing customer</option>
				<option value="Other">Other</option>
			</select>
			<div class="formFieldExplanatoryTextAfterInput">Where did you hear about me?</div>
		</div>  
		<div class="formField">
			<h3 class="formHeading">Main Contact</h3>
		</div>  
		<div class="formContacts" id="formContacts1">
			<div class="formContactsEmpty" id="formContactsEmpty1" style="display: none;">You haven't added any people to this section yet.</div>
			<div class="formContact" id="ContactSPRTRnew1">
				<div class="formFieldName">
					<div class="formFieldNameFirst">
						<h3 class="formFieldHeading">First Name <span class="formRequired">(required)</span></h3>
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactNameFirstSPRTRnew1" name="ContactSPRTRMainSPRTRContactNameFirstSPRTRnew1" value="" hashadvalue="false">
					</div>  
					<div class="formFieldNameLast">
						<h3 class="formFieldHeading">Last Name <span class="formRequired">(required)</span></h3>
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactNameLastSPRTRnew1" name="ContactSPRTRMainSPRTRContactNameLastSPRTRnew1" value="" hashadvalue="false">
					</div>  
					<div class="giverOfHeight"></div>
				</div>  
				<div class="formField">
					<h3 class="formFieldHeading">Company</h3>
					<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactCompanyNameSPRTRnew1" name="ContactSPRTRMainSPRTRContactCompanyNameSPRTRnew1" value="" hashadvalue="false">
				</div>  
				<div class="formField">
					<h3 class="formFieldHeading">Email Address <span class="formRequired">(required)</span></h3>
					<input class="formEmailInput" type="email" id="ContactSPRTRMainSPRTRContactEmailSPRTRnew1" name="ContactSPRTRMainSPRTRContactEmailSPRTRnew1" value="">
				</div>  
				<div class="formField">
					<h3 class="formFieldHeading">Phone Number</h3>
					<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactPhoneSPRTRnew1" name="ContactSPRTRMainSPRTRContactPhoneSPRTRnew1" value="" hashadvalue="false">
					<select class="formContactPhonePopupMenu" id="ContactSPRTRMainSPRTRContactPhoneTypeSPRTRnew1" name="ContactSPRTRMainSPRTRContactPhoneTypeSPRTRnew1">
						<option value="Mobile" selected="">Mobile</option>
						<option value="Home">Home</option>
						<option value="Work">Work</option>
					</select>
				</div>  
				<div class="formField">
					<h3 class="formFieldHeading">Mobile</h3>
					<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactPhoneMobileSPRTRnew1" name="ContactSPRTRMainSPRTRContactPhoneMobileSPRTRnew1" value="" hashadvalue="false">
				</div>  
				<div class="formField">
					<h3 class="formFieldHeading">Address</h3>
					<div class="formAddressLine">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddress1SPRTRnew1" name="ContactSPRTRMainSPRTRContactAddress1SPRTRnew1" value="" hashadvalue="false">
						<div class="formFieldExplanatoryTextAfterInput">Street Address</div>
					</div>
					<div class="formAddressLine">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddress2SPRTRnew1" name="ContactSPRTRMainSPRTRContactAddress2SPRTRnew1" value="" hashadvalue="false">
						<div class="formFieldExplanatoryTextAfterInput">Address Line 2</div>
					</div>
					<div class="formAddressLine">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddress3SPRTRnew1" name="ContactSPRTRMainSPRTRContactAddress3SPRTRnew1" value="" hashadvalue="false">
						<div class="formFieldExplanatoryTextAfterInput">Address Line 3</div>
					</div>
					<div class="formAddressLine">
						<div class="formAddressLineLeft">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddressCitySPRTRnew1" name="ContactSPRTRMainSPRTRContactAddressCitySPRTRnew1" value="" hashadvalue="false">
							<div class="formFieldExplanatoryTextAfterInput">City</div>
						</div>
						<div class="formAddressLineRight">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddressCountySPRTRnew1" name="ContactSPRTRMainSPRTRContactAddressCountySPRTRnew1" value="" hashadvalue="false">
							<div class="formFieldExplanatoryTextAfterInput">County</div>
						</div>
						<div class="giverOfHeight"></div>
					</div>
					<div class="formAddressLine">
						<div class="formAddressLineLeft">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddressPostCodeSPRTRnew1" name="ContactSPRTRMainSPRTRContactAddressPostCodeSPRTRnew1" value="" hashadvalue="false">
							<div class="formFieldExplanatoryTextAfterInput">Postcode</div>
						</div>
						<div class="formAddressLineRight">
						<input class="formTextInput" type="text" id="ContactSPRTRMainSPRTRContactAddressCountrySPRTRnew1" name="ContactSPRTRMainSPRTRContactAddressCountrySPRTRnew1" value="" hashadvalue="false">
							<div class="formFieldExplanatoryTextAfterInput">Country</div>
						</div>
						<div class="giverOfHeight"></div>
					</div>
				</div>  
				<div class="formContactEnd">&nbsp;</div>
			</div> 
		</div> 
		<div id="formSubmit"><p><a id="submitButton" class="btnDisabled">Submit</a></p></div>
		<div id="formSubmitButtonWarning">You must fill in all required fields before submitting this form.</div> -->
	</form>
</div>