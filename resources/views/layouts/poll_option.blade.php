<div class="form-group" id="idOption">
    {!! Form::file('optionImage[idOption]', [
      'class' => 'file',
    ]) !!}
    <div class="input-group date datetimepicker" id="option-poll">
        {!! Form::text('optionText[idOption]', null, [
            'class' => 'form-control',
            'id' => 'optionText-idOption',
            'placeholder' => trans('polls.placeholder.option'),
            'onfocus' => "addAutoOption('idOption')",
            'onclick' => "addAutoOption('idOption')",
            'onblur' => "checkOptionSame(this)",
            'onkeyup' => "checkOptionSame(this)",
        ]) !!}
        <span class="input-group-addon pick-date">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
        <span class="input-group-btn">
            <button class="btn btn-darkcyan-not-shadow upload-photo" type="button">
                <span class="glyphicon glyphicon-picture"></span>
            </button>
            <button class="btn btn-danger btn-remove-option" type="button" onclick="removeOpion('idOption')">
                <span class="glyphicon glyphicon-trash"></span>
            </button>
        </span>
    </div>
    <img id="preview-idOption" src="a.jpg" class="preview-image"/>
</div>
