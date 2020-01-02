
-- consulta de la tabla de provvvedores con precio
SELECT pp.id, pp.precio, pp.info, pp.fecha, prov.nombre as proveedor, art.nombre as articulo, art.unidadA as presentacion, art.unidad, art.factor, ( IF(art.factor = 0, 1, art.factor) * pp.precio ) as total FROM `proveedor` as prov left join precioprov as pp on pp.proveedor = prov.idProveedor left join articulo as art on art.idArticulo = pp.articulo WHERE 1;