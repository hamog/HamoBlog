<div class="form-group">
    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('category', 'Category', ['class' => 'control-label']) !!}
    {!! Form::select('category', $categories , null , ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('tags', 'Select Tags', ['class' => 'control-label']) !!}
    {!! Form::select('tags[]', $tags, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'tags']) !!}
</div>
<div class="form-group">
    {!! Form::label('body', 'Body', ['class' => 'control-label']) !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('image', 'Select Image', ['class' => 'control-label']) !!}
    {!! Form::file('image') !!}
</div>