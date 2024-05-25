use linea;
select * from usuario;
select * from producto;
select * from producto_cotizado;
select * from cotizacion;
select * from carrito;
select * from compra;
select * from categoria_producto;

-- Lina procedure insert de compra que hay que crear IMPORTANTE CREAR LA VISTA DED ABAJO Q_UE SE LLAMA compra_vista
drop procedure insert_compra;
delimiter //
create procedure insert_compra (in id_user int) 
begin
insert into carrito2 select * from carrito;
insert into compra (comprador, id_pro, cant_pro, fecha_compra, precio, estatus, id_carrito, id_coti ) 
select * from compra_vista where id_usuario=id_user;
truncate carrito2;
end//
delimiter;

-- lina estos son los triggers
drop trigger if exists log_compra;

delimiter //
create trigger log_compra after insert on compra
for each row begin
update producto set pro_cantidad = pro_cantidad - new.cant_pro where id_pro= new.id_pro;
end//
delimiter;

drop trigger log_compra_carrito;
delimiter //
create trigger log_compra_carrito after insert on compra
for each row begin

update carrito
set carr_estatus=1
where ID_CARRITO=new.id_carrito;

end //
delimiter;

delimiter //
create trigger log_compra_cotizacion after insert on compra
for each row begin
update cotizacion
set cotizacion_estado=1
where id_coti=new.id_coti;
end//
delimiter;
-- ALAN este era de prueba, ignorar
-- insert into compra (comprador, id_pro, cant_pro, fecha_compra, precio, estatus, id_carrito,id_coti) values(4,2,2,now(),8000,0,3,2 );

-- call insert_compra (5);

-- insert into compra (comprador, id_pro, cant_pro, fecha_compra, precio, estatus, id_carrito, id_coti ) 
-- select * from compra_vista where id_usuario=4;

drop view compra_vista;
create view compra_vista as
select id_usuario, id_producto, carr_cantidad, now(), pro_precio_total_calculado, 0 , id_carrito, id_coti from carrito2 where carr_estatus=0;

-- select * from compra_vista;

-- select * from carrito2;


