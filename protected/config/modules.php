<?php
return array(

    /*
     * Modulo para mostrar el dashboard
     * y al que se redirecciona al logearce en el back
     */
    'admin' => array(
        'class' => 'ext.modules.admin.AdminModule',
        // 'showMenuFromAdmin'=>false,
    ),
    
    'home'=>array(
        'class'=>'application.modules.home.HomeModule',
        // 'showMenuFromAdmin'=>false,
    ),
    /**
     * Modulo para le manejo de usuarios
     * session, reistro, recuperar contraseña etc
     * este módulo se puede ir mejorando segun
     * las necesidades, en su núcleo está
     * desarrollado con el nombre de las variables
     * en ingles, porque es posible que algun proyecto
     * sea requerido en ingles
     *
     * Si quieres hacer relaciones o modificar el modelo
     * y la tabla de usuarios solo para tu proyecto
     * debes redefinir el modelo extendiendo Users
     */
    'users' => array(
        'class' => 'ext.modules.users.UsersModule',
        'redirectLogin' => array('/home'),
        'enableOAuth' => true,
        // 'showMenuFromAdmin'=>false,
        // 'labelMenu' => 'Usuarios',
    ),
    
    /*
     * Modulo para almacenar las variables de cofigursción general de la applicacion
     */
    'settings' => array(
        'class' => 'ext.modules.settings.SettingsModule',
        // 'showMenuFromAdmin'=>false,
    ),

    'smtp'=>array(
        'class'=>'ext.modules.smtp.SmtpModule',
        // 'showMenuFromAdmin'=>false,
    ),

    /*
     * Modulo para generar código
     * este solo se muestra en ambiente local no en 
     * producción
     */
    'gii' => array(
        'class' => 'ext.modules.gii.GiiModule',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        'ipFilters' => array('127.0.0.1', '::1'),
        'showMenuFromAdmin'=>YII_DEBUG,
    ),
    'crm'=>array(
        'class'=>'application.modules.crm.CrmModule',
        // 'showMenuFromAdmin'=>false, // If you want hide your module on CMS left menu
     ),
);