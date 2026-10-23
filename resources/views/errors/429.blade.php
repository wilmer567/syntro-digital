@extends('errors.layout')

@section('title', 'Límite de solicitudes')
@section('code', '429')
@section('heading', 'Demasiadas solicitudes')
@section('message', 'Has superado el límite de intentos permitidos. Por motivos de seguridad, por favor espera un momento antes de reintentar.')
