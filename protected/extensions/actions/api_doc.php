<?php
/* @var $this BackController */

$this->breadcrumbs=array(
	"API",
);
?>


<div class="row">
	<div class="col-lg-12">

<section class="panel">
    <div class="panel-body minimal">
        <div class="table-inbox-wrap">
			
        <ul class="nav nav-tabs">
            <li class="active"><a href="#endpoints" data-toggle="tab">Endpoints</a></li>
            <li><a href="#authentication" data-toggle="tab">Authentication</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade active in" id="endpoints">
            	
<?php foreach($documentation as $data):?>

<h3><span class="label <?php echo $this->getLabel($data['method'])?>"><?php echo strtoupper($data['method'])?></span> <?php echo Yii::app()->request->getBaseUrl(true).'/'.$data['url']?></h3> 
<h4 class="mtl">
<!-- Button trigger modal -->
<button class="btn btn-sm" data-toggle="modal" data-target="#<?php echo strtr($data['url'],array("/"=>"_","{"=>"_","}"=>"_"))?>_modal">
  <i class="fa fa-eye"></i>
</button>
    <em><?php echo isset($data['action'])?$data['action']:''?></em></h4>

<!-- ////////////////////////////////////////////////// -->
<!-- Modal in order to update or create a detail record -->
<!-- ////////////////////////////////////////////////// -->
<div class="modal fade" id="<?php echo strtr($data['url'],array("/"=>"_","{"=>"_","}"=>"_"))?>_modal" tabindex="-1" role="<?php echo strtr($data['url'],array("/"=>"_","{"=>"_","}"=>"_"))?>_modal" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">
<span class="label <?php echo $this->getLabel($data['method'])?>"><?php echo strtoupper($data['method'])?></span> <?php echo Yii::app()->request->getBaseUrl(true).'/'.$data['url']?>
            </h4>
        </div>
        <div class="modal-body">
<h5 class="">
    <em><?php echo isset($data['action'])?$data['action']:''?></em></h5>


<h3>Availables params</h3>
<table class="table">
    <thead>
    <tr>
        <th>Param name</th>
        <th>Description</th>
        <th>Required</th>
        <th>Default</th>
    </tr>
    </thead>
    
    <tbody>
<?php if(isset($data['params'])):?>
<?php foreach($data['params'] as $param):?>
        <tr>
            <td><code><?php echo isset($param['name'])?$param['name']:''?></code></td>
            <td><?php echo isset($param['description'])?$param['description']:''?></td>
            <td><?php echo isset($param['required'])?Yii::app()->format->boolean($param['required']):''?></td>
            <td><?php echo isset($param['defaultValue'])?$param['defaultValue']:''?></td>
        </tr>
<?php endforeach;?>
<?php endif;?>
    </tbody>
</table>

<h3>Success Response</h3>
<pre><?php echo isset($data['success_response'])?Yii::app()->format->prettyJSON($data['success_response']):'No actualizado'?></pre>

<h3>Error Response</h3>
<pre><?php echo isset($data['success_response'])?Yii::app()->format->prettyJSON($data['error_response']):'No actualizado'?></pre>
<br>

        </div>
        </div>
    </div>
</div>
<hr class="mtl">
<?php endforeach;?>

            </div>
            <div class="tab-pane fade" id="authentication"><h3>Authentication via OAuth</h3>

<p>
    API uses OAuth for authentication and supports the following
    grant types:
</p>

<ul>
    <li>Client Credentials</li>
    <li>Authorization Code</li>
</ul>

<p>
    Here are the important endpoints and their parameters
</p>

<table class="table table-striped">
    <thead>
        <tr>
            <th>URL</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>POST users/page/token</td>
            <th>
                <p>
                    The endpoint used for requesting an access token, using
                    either the authorization_code or client_credentials grant
                    type.
                </p>

                <code>
                    <?php echo Yii::app()->request->getBaseUrl(true)?>/users/page/token
                </code>

                <p>
                    This accepts the following POST fields:
                </p>

                <ul>
                    <li>
                        <code>client_id</code>
                    </li>
                    <li>
                        <code>client_secret</code>
                    </li>
                    <li>
                        <code>grant_type</code> Either client_credentials or authorization_code
                    </li>
                    <li>
                        <code>redirect_uri</code> (authorization_code only) Must match redirect_uri from the original /authorize call
                    </li>
                    <li>
                        <code>code</code> (authorization_code only) The authorization code
                    </li>
                </ul>
            </th>
        </tr>
        <tr>
            <td>GET users/page/authorize</td>
            <td>
                <p>
                    When using the authorization code (traditional "web") grant
                    type, start by redirecting the user to this URL:
                </p>

                <code>
                    <?php echo Yii::app()->request->getBaseUrl(true)?>/users/page/authorize
                </code>

                <p>
                    This accepts the following GET parameters
                </p>

                <ul>
                    <li>
                        <code>client_id</code>
                    </li>
                    <li>
                        <code>response_type</code> Either code or token
                    </li>
                    <li>
                        <code>redirect_uri</code> (authorization_code only)
                    </li>
                    <li>
                        <code>scope</code> The permissions the user should authorize, separated by a space
                    </li>
                    <li>
                        (Optional) <code>state</code> A key that's returned on the redirect_uri
                        that can be used as a CSRF token.
                    </li>
                </ul>

                <p style="margin-top: 20px;">
                    Once the user is redirected back to <code>redirect_uri</code>,
                    you'll have a <code>code</code> query parameter. Use
                    this with the next endpoint to exchange that code for
                    an access token.
                </p>

            </td>
        </tr>
    </tbody>
</table>

<div><h3>Authorizing your API Requests</h3>

<p>
    Once you have an access token, send it via the <code>Authorization</code> header:
</p>

<pre>POST /resource-name HTTP/1.1
Host: <?php echo strtr(Yii::app()->request->getBaseUrl(true),array("http://"=>"","https://"=>"")).'/<br>'?>
Authorization: Bearer YOURACCESSTOKENHERE</pre>
</div>

</div>

            
        </div>
    
        </div>
    </div>
</section>


		
	</div>
</div>