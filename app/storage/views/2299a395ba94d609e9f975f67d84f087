<!-- Child Help Modal -->
<div class="modal fade" id="mdChildhelp" tabindex="-1" role="dialog" aria-labelledby="mdChildhelpLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mdChildhelpLabel">What is a "Child Feature"</h4>
      </div>
      <div class="modal-body">

        <!-- modal body content -->
        <p>
          A "Child Feature" might be required if you wish to create a Group of fields. 
          In such cases, typically one would create a field with Input Type "Label" and add childs to it. 
          A "Child" field would always have its parent as the first field of the form.
        </p>

        <h4>When should I create a "Child" field</h4>

        <p>
          As a rule of thumb, if you want multiple fields in Provisioning you need to create childs, 
          but if a single field is needed then one should not create a "Child" field. 
          Each field in a form would create a corresponding field while Provisioning. 
          So, creating unwanted "Child" fields would create unwanted Provisioning field and can have unexpected results.
        </p>

        <p>
          All input, validation and other rules and principles are applicable for "Child" fields too.
        </p>

        <p>
          <b>IMPORTANT: A new "Child Feature" or any changes to an existing "Child Feature" is ignored if the "Feature Name" 
            field for the particular "Child" entry is blank and data is not saved to the database.</b>
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Input Type Help Modal -->
<div class="modal fade" id="mdInputtype" tabindex="-1" role="dialog" aria-labelledby="mdInputtypeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mdInputtypeLabel">Knowing "Input Type"</h4>
      </div>
      <div class="modal-body">

        <!-- modal body content -->
        <p>
          "Input Type" allows you to specify how the field is drawn while creating a Template. 
          Combined with "Data Type", it also helps in determining the "datatype" of the underlying field.
        </p>

        <h4>The Available Input Types</h4>

        <p>
          <b>"Drop-down"</b> would draw a Drop-down box to accept user input while creating a Template.
          The "Values" field is required if the Input Type is selected as "Drop-down".
          The data entered in "Values" field is used to create the Drop-down options. 
          More details are available in "Values" help.
        </p>

        <p>
          <b>"IP"</b> would draw a Text-box to accept user input while creating a Template.
          It also ignores the entered Data Type and assumes it to be "Numeric".
        </p>

        <p>
          <b>"IP Range"</b> would draw a Label and show the content of the "Feature Name" field within it.
          Then it would draw two Text-boxes to accept user input while creating a Template. 
          The first Text-box would be labeled "Start" and the second would be labeled "End".
          It also ignores the entered Data Type and assumes it to be "Numeric".
        </p>

        <p>
          <b>"Label"</b> would draw a Label and show the content of the "Feature Name" field within it.
          It should be used if you wish to create a Field Group with the field marked "Label" as the Group title.
        </p>

        <p>
          <b>"Range"</b> would draw a Label and show the content of the "Feature Name" field within it.
          Then it would draw two Text-boxes to accept user input while creating a Template. 
          The first Text-box would be labeled "Start" and the second would be labeled "End".
          Range can have Data Type values of "Numeric" type or "Text".
          For <b>"Text"</b> type, a typical range would have start and end values of "a" &amp; "z" or "A" &amp; "Z".
          Other values might cause unexpected results.
          <b>"Numeric"</b> ranges work on "Numeric" datatype principles.
          <b>"Incrementing"</b> range would generate and add a value incremented by <b>"1"</b> from the last value of the same field and of the same Template.
        </p>

        <p>
          <b>"Text-box"</b> would draw a Text-box to accept user input while creating a Template.
        </p>

        <p>
          <b>"Text-area"</b> would draw a Text-area to accept user input while creating a Template.
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Data Type Help Modal -->
<div class="modal fade" id="mdDatatype" tabindex="-1" role="dialog" aria-labelledby="mdDatatypeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mdDatatypeLabel">Working with "Data Type"</h4>
      </div>
      <div class="modal-body">

        <!-- modal body content -->
        <p>
          Data Type allows you to specify the "datatype" of the values that would be entered when creating a Template. 
          It is required as certain operations and validations are "datatype" dependent.
          It also helps determine how values are generated assigned while Provisioning from a Template.
        </p>

        <h4>The Available Data Types</h4>

        <p>
          Data Type works along with "Input Type" to determine the actual "datatype" of a field.
        </p>

        <p>
          <b>"Incrementing"</b> would make the "datatype" of the underlying field as of "Numeric" type. 
          When a value for a field is generated and assigned during Provisioning, the value would be generated incrementing by <b>"1"</b> 
          from the last value of the same field for the same Template. 
          If the Input Type is of type "Range" or "IP Range" then it would check if the generated value is within the limits of the range 
          else generate an error message and stop Provisioning.
        </p>

        <p>
          <b>"Numeric"</b> would make the "datatype" of the underlying field as of "Numeric" type.
        </p>

        <p>
          <b>"Text"</b> would make the "datatype" of the underlying field as of "Character" type.
        </p>

        <p>
          Data Type for Input Types "IP" and "IP Range" is ignored and is always considered as "Numeric".
        </p>

        <p>
          Data Type for Input Type "Text-area" is always considered as "Text".
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Values Help Modal -->
<div class="modal fade" id="mdValues" tabindex="-1" role="dialog" aria-labelledby="mdValuesLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mdValuesLabel">Adding Values for Feature</h4>
      </div>
      <div class="modal-body">

        <!-- modal body content -->
        <p>
          Values are required when you want users to enter from a predefined set of values.
          Its used for drop-downs to generate the list of options.
        </p>

        <h4>How to Add Values</h4>

        <p>
          Values are a comma "," separated list of text which would be shown as options for drop-downs. 
          There should not be any space before or after the comma separator as the space would appear in the drop-down option itself.
          Values which have comma within are not allowed and would be treated as a separate option.
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Validation Help Modal -->
<div class="modal fade" id="mdValidation" tabindex="-1" role="dialog" aria-labelledby="mdValidationLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mdValidationLabel">Working with Feature Validations</h4>
      </div>
      <div class="modal-body">

        <!-- modal body content -->
        <h4>How to Add Validations</h4>
        <p>Validations are added as rules which are validated while creating Templates. 
          A field might be validated against one or multiple rule. Multiple rules are separated by a pipe "|" symbol.
          In case of multiple rules, validation is done in the order they have been added. 
          If a rule fails then subsequent validation is stopped for the validating field and error message is returned.
        </p>
        <p>A valid rule would begin with RULE name. 
          If additional parameters are needed they are added after a colon sign ":". 
          Multiple parameters are separated by a comma ",".
        </p>
        <p>
          As an example "max:5|numeric". Here two rules, namely "max" and "numeric" have been added and separated by a pipe symbol.
          "max" is the first rule. It passes a parameter with value "2" to the Validation engine.
        </p>

        <h4>Available Validations</h4>
        <p>
          <b>alpha</b><br/>
          The field under validation must be entirely alphabetic characters.
        </p>
        <p>
          <b>alpha_num</b><br/>
          The field under validation must be entirely alpha-numeric characters.
        </p>
        <p>
          <b>between:min,max</b><br/>
          The field under validation must have a size between the given min and max.
          Strings and numerics are evaluated in the same fashion as the size rule.
        </p>

        <p>
          <b>digits:value</b><br/>
          The field under validation must be numeric and must have an exact length of value.
        </p>

        <p>
          <b>digits_between:min,max</b><br/>
          The field under validation must have a length between the given min and max.
        </p>

        <p>
          <b>distinct</b><br/>
          The field under validation would have a distinct value. Typically used with Range, IP Range or Text field types. 
          For Range or IP Range, an incremental value is generated to make the value distinct.
        </p>

        <p>
          <b>email</b><br/>
          The field under validation must be formatted as an e-mail address.
        </p>

        <p>
          <b>in:foo,bar,…</b><br/>
          The field under validation must be included in the given list of values.
        </p>

        <p>
          <b>integer</b><br/>
          The field under validation must have an integer value.
        </p>

        <p>
          <b>ip</b><br/>
          The field under validation must be formatted as an IP address.
        </p>

        <p>
          <b>max:value</b><br/>
          The field under validation must be less than a maximum value. 
          Strings, numerics, and files are evaluated in the same fashion as the size rule.
        </p>

        <p>
          <b>min:value</b><br/>
          The field under validation must have a minimum value. 
          Strings, numerics, and files are evaluated in the same fashion as the size rule.
        </p>

        <p>
          <b>not_in:foo,bar,…</b><br/>
          The field under validation must not be included in the given list of values.
        </p>

        <p>
          <b>numeric</b><br/>
          The field under validation must have a numeric value. 
        </p>

        <p>
          <b>size:value</b><br/>
          The field under validation must have a size matching the given value.
          For string data, value corresponds to the number of characters. 
          For numeric data, value corresponds to a given integer value.
        </p>

        <p>
          <b>url</b><br/>
          The field under validation must be formatted as an URL.
        </p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
