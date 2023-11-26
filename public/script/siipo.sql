DROP DATABASE IF EXISTS siipo;
CREATE DATABASE siipo;
USE siipo;

CREATE TABLE roles ( -- Tabla de Roles para el Usuario
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del rol
    NombreRol VARCHAR(20) UNIQUE NOT NULL, -- Nombre del rol
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users ( -- Tabla de Usuarios
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del usuario
    Nombre VARCHAR(30) NOT NULL, -- Nombre del usuario
    CURP VARCHAR(18) UNIQUE NOT NULL, -- Curp del usuario
    Email VARCHAR(30), -- Correo electrónico del usuario
    Password VARCHAR(20) NOT NULL, -- Contraseña del usuario
    Rolid INT NOT NULL, -- Identificador del rol del usuario
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Rolid) REFERENCES roles(id) -- Llave foránea del rol del usuario con el identificador del rol-Rolid
);

CREATE TABLE permisos ( -- Tabla para los permisos
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del permiso
    NombrePermiso VARCHAR(30) UNIQUE NOT NULL, -- Nombre del permiso
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE asignacion_permisos ( -- Tabla para la asignación de permisos a los roles
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del permiso asignado
    Rolid INT NOT NULL, -- Identificador del rol
    Perid INT NOT NULL, -- Identificador del permiso
    Permitido BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el permiso está permitido o no
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Rolid) REFERENCES roles(id), -- Llave foránea del rol con el identificador del rol-Rolid
    FOREIGN KEY (Perid) REFERENCES permisos(id) -- Llave foránea del permiso con el identificador del permiso-Perid
);

CREATE TABLE regiones ( -- Tabla para las regiones
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la región
    NombreRegion VARCHAR(40) UNIQUE NOT NULL, -- Nombre de la región
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE distritos ( -- Tabla para los distritos
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del distrito
    NombreDistrito VARCHAR(30) UNIQUE NOT NULL, -- Nombre del distrito
    Regid INT NOT NULL, -- Identificador de la región
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Regid) REFERENCES regiones(id) -- Llave foránea de la región con el identificador de la región-Regid
);

CREATE TABLE municipios ( -- Tabla para los municipios
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del municipio
    NombreMunicipio VARCHAR(30) NOT NULL, -- Nombre del municipio
    Disid INT NOT NULL, -- Identificador del distrito
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Disid) REFERENCES distritos(id) -- Llave foránea del distrito con el identificador del distrito-Disid
);

CREATE TABLE localidades ( -- Tabla para las localidades
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la localidad
    NombreLocalidad VARCHAR(30) NOT NULL, -- Nombre de la localidad
    Munid INT NOT NULL, -- Identificador del municipio
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Munid) REFERENCES municipios(id) -- Llave foránea del municipio con el identificador del municipio-Munid
);

CREATE TABLE oficinas ( -- Tabla para las oficinas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la oficina
    NombreOficina VARCHAR(50) NOT NULL, -- Nombre de la oficina
    Ubicacion VARCHAR(100) NOT NULL, -- Ubicación de la oficina
    Telefono VARCHAR(10) NOT NULL, -- Teléfono de la oficina
    Email VARCHAR(40) NOT NULL, -- Email de la oficina
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE unidad_economica_pa_fisico ( -- Tabla para las unidades económicas de personas físicas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la unidad económica
    Ofcid INT NOT NULL, -- Identificador de la oficina
    Locid INT NOT NULL, -- Identificador de la localidad
    FechaRegistro DATE NOT NULL, -- Fecha de registro de la unidad económica
    RNPA VARCHAR(10), -- RNPA del pescador o acuicultor fisico
    CURP VARCHAR(18) UNIQUE NOT NULL, -- CURP del pescador o acuicultor fisico
    RFC VARCHAR(12), -- Rfc del pescador o acuicultor fisico
    Nombres VARCHAR(50) NOT NULL, -- Nombres del pescador o acuicultor fisico
    ApPaterno VARCHAR(30) NOT NULL, -- Apaterno del pescador o acuicultor fisico
    ApMaterno VARCHAR(30) NOT NULL, -- Apaterno del pescador o acuicultor fisico
    FechaNacimiento DATE NOT NULL, -- Fecha de nacimiento del pescador o acuicultor fisico
    Sexo ENUM ('M', 'F') NOT NULL, -- Sexo del pescador o acuicultor fisico
    GrupoSanguineo VARCHAR(4), -- Grupo sanguineo del pescador o acuicultor fisico
    Email VARCHAR(40), -- Email del pescador o acuicultor fisico
    Calle VARCHAR(100) NOT NULL, -- Calle del domicilio
    NmExterior VARCHAR(6) NOT NULL, -- Número exterior del domicilio
    NmInterior VARCHAR(6) NOT NULL, -- Número interior del domicilio
    CodigoPostal VARCHAR(10), -- Código postal del domicilio
    Colonia VARCHAR(100) NOT NULL, -- Colonia del domicilio
    IniOperaciones DATE NOT NULL, -- Fecha de inicio de operaciones del pescador o acuicultor fisico
    ActivoEmbMayor BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el pescador o acuicultor fisico tiene embarcaciones mayores
    ActivoEmbMenor BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el pescador o acuicultor fisico tiene embarcaciones menores
    ActvAcuacultura BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el pescador o acuicultor fisico tiene actividad de acuacultura
    ActvPesca BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el pescador o acuicultor fisico tiene actividad de pesca
    DocActaNacimiento VARCHAR(255) NOT NULL, -- Documento de acta de nacimiento del representante de la cooperativa
    DocComprobanteDomicilio VARCHAR(255) NOT NULL, -- Documento de comprobante de domicilio de la cooperativa
    DocCURP VARCHAR(255) NOT NULL, -- Documento de CURP del representante de la cooperativa
    DocIdentificacionOfc VARCHAR(255) NOT NULL, -- Documento de identificación oficial del representante de la cooperativa
    DocRFC VARCHAR(255) NOT NULL, -- Documento de RFC de la cooperativa
    DocActaConstitutiva VARCHAR(255) NOT NULL, -- Documento de acta constitutiva de la cooperativa
    DocActaAsamblea VARCHAR(255) NOT NULL, -- Documento de acta de asamblea de la cooperativa
    DocRepresentanteLegal VARCHAR(255) NOT NULL, -- Documento del representante de la cooperativa
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Ofcid) REFERENCES oficinas(id), -- Llave foránea de la oficina con el identificador de la oficina-Ofcid
    FOREIGN KEY (Locid) REFERENCES localidades(id) -- Llave foránea de la localidad con el identificador de la localidad-Locid
);

CREATE TABLE telefonos_pa_fisico ( -- Tabla para los teléfonos de las unidades económicas de personas físicas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del teléfono
    Numero VARCHAR(10) NOT NULL, -- Número del teléfono
    NumeroPrincipal BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el teléfono es el principal
    Tipo VARCHAR(20) NOT NULL, -- Tipo de teléfono
    UEPAFid INT NOT NULL, -- Identificador de la unidad económica
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEPAFid) REFERENCES unidad_economica_pa_fisico(id) -- Llave foránea de la unidad económica con el identificador de la unidad económica-UEPAFid
);

CREATE TABLE artes_pesca ( -- Tabla para las artes de pesca
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del arte de pesca
    NombreArtePesca VARCHAR(50) NOT NULL, -- Nombre del arte de pesca
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE especies ( -- Tabla para las especies
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la especie
    NombreEspecie VARCHAR(50) NOT NULL, -- Nombre de la especie
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, --
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE productos ( -- Tabla para los productos
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del producto
    NombreComun VARCHAR(50) NOT NULL, -- Nombre común del producto
    NombreCientifico VARCHAR(100) NOT NULL, -- Nombre científico del producto
    TPEspecieid INT NOT NULL, -- Identificador de la especie
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id) -- Llave foránea de la especie con el identificador de la especie-TPEspecieid
);

CREATE TABLE permisos_pesca ( -- Tabla para los permisos de pesca
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del permiso de pesca
    NombrePermiso VARCHAR(50) NOT NULL, -- Nombre del permiso de pesca
    TPEspecieid INT NOT NULL, -- Identificador de la especie
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id) -- Llave foránea de la especie con el identificador de la especie-TPEspecieid
);

CREATE TABLE permisos_pesca_por_pa_fisico ( -- Tabla para los permisos de pesca por persona física
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Tabla para los permisos de pesca por persona física
    FolioPermiso VARCHAR(50) UNIQUE NOT NULL, -- Folio del permiso de pesca
    FechaExpedicion DATE NOT NULL, -- Fecha de expedición del permiso de pesca
    FechaVigencia DATE NOT NULL, -- Fecha de vigencia del permiso de pesca
    EstatusPermiso BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el permiso de pesca está activo o no
    Nota TEXT, -- Nota del permiso de pesca
    TPPPescaid INT NOT NULL, -- Identificador del permiso de pesca
    UEPAFid INT NOT NULL, -- Identificador de la unidad económica
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPPPescaid) REFERENCES permisos_pesca(id), -- Llave foránea del permiso de pesca con el identificador del permiso de pesca-TPPPescaid
    FOREIGN KEY (UEPAFid) REFERENCES unidad_economica_pa_fisico(id) -- Llave foránea de la unidad económica con el identificador de la unidad económica-UEPAFid
);

CREATE TABLE artes_pesca_permisos_pa_fisico ( -- Tabla para las artes de pesca por permiso de pesca por persona física
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la tabla
    TPArtPescaid INT NOT NULL, -- Identificador del arte de pesca
    PPPAFid INT NOT NULL, -- Identificador del permiso de pesca
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (PPPAFid) REFERENCES permisos_pesca_por_pa_fisico(id), -- Llave foránea del permiso de pesca con el identificador del permiso de pesca-PPPAFid
    FOREIGN KEY (TPArtPescaid) REFERENCES artes_pesca(id) -- Llave foránea del arte de pesca con el identificador del arte de pesca-TPArtPescaid
);



CREATE TABLE unidad_economica_pa_moral ( -- Tabla para las unidades económicas para las cooperativas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la unidad económica
    UEDuenoid INT NOT NULL, -- Identificador de la unidad económica de cooperativas
    Ofcid INT NOT NULL, -- Identificador de la oficina
    FechaRegistro DATE NOT NULL, -- Fecha de registro de la unidad económica
    RNPA VARCHAR(10) NOT NULL, -- RNPA de la cooperativa
    RFC VARCHAR(13) NOT NULL, -- RFC de la cooperativa
    RazonSocial VARCHAR(50) NOT NULL, -- Razón social de la cooperativa
    Email VARCHAR(40),-- Email de la cooperativa
    Calle VARCHAR(100) NOT NULL, -- Calle del domicilio
    NmExterior VARCHAR(6) NOT NULL, -- Número exterior del domicilio
    NmInterior VARCHAR(6) NOT NULL, -- Número interior del domicilio
    CodigoPostal VARCHAR(10), -- Código postal del domicilio
    LocID INT NOT NULL, -- Identificador de la localidad
    Colonia VARCHAR(100) NOT NULL, -- Colonia del domicilio
    IniOperaciones DATE NOT NULL, -- Fecha de inicio de operaciones de la cooperativa
    ActvAcuacultura BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si la cooperativa es de actividad de acuacultura
    ActvPesca BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si la cooperativa es de actividad de pesca
    ActivoEmbMayor BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si la cooperativa tiene embarcaciones mayores
    ActivoEmbMenor BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si la cooperativa tiene embarcaciones menores
    CantidadPescadores INT, -- Cantidad de pescadores de la cooperativa

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Ofcid) REFERENCES oficinas(id), -- Llave foránea de la oficina con el identificador de la oficina-Ofcid
    FOREIGN KEY (Locid) REFERENCES localidades(id), -- Llave foránea de la localidad con el identificador de la localidad-Locid
    FOREIGN KEY (UEDuenoid) REFERENCES unidad_economica_pa_fisico(id) -- Llave foránea de la unidad económica de cooperativas con el identificador de la unidad económica de cooperativas-UEDuenoid
);

CREATE TABLE telefonos_pa_moral ( -- Tabla para los teléfonos de las unidades económicas de cooperativas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del teléfono
    Numero VARCHAR(10) NOT NULL, -- Número del teléfono
    NumeroPrincipal BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el teléfono es el principal
    Tipo VARCHAR(20) NOT NULL, -- Tipo del teléfono
    UEPAMid INT NOT NULL, -- Identificador de la unidad económica
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEPAMid) REFERENCES unidad_economica_pa_moral(id) -- Llave foránea de la unidad económica con el identificador de la unidad económica-UEPAMid
);

CREATE TABLE socios_detalles_pa_moral ( -- Tabla para los socios de las unidades económicas de cooperativas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del socio
    CURP VARCHAR(18) NOT NULL, -- CURP del socio
    TipoPA BOOLEAN DEFAULT TRUE NOT NULL, -- Indica si el socio es pescador o acuicultor
    DocActaNacimiento VARCHAR(255) NOT NULL, -- Documento de acta de nacimiento del socio
    DocComprobanteDomicilio VARCHAR(255) NOT NULL, -- Documento de comprobante de domicilio del socio
    DocCURP VARCHAR(255) NOT NULL, -- Documento de CURP del socio
    DocIdentificacionOfc VARCHAR(255) NOT NULL, -- Documento de identificación oficial del socio
    DocRFC VARCHAR(255) NOT NULL, -- Documento de RFC del socio
    UEPAMid INT NOT NULL, -- Identificador de la unidad económica de cooperativas
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEPAMid) REFERENCES unidad_economica_pa_moral(id) -- Llave foránea de la unidad económica de cooperativas con el identificador de la unidad económica de cooperativas-UEPAMid
);

CREATE TABLE permisos_pesca_por_pa_moral( -- Tabla para los permisos de pesca por unidad económica de cooperativas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del permiso de pesca
    FolioPermiso VARCHAR(50) UNIQUE NOT NULL, -- Folio del permiso de pesca
    FechaExpedicion DATE NOT NULL, -- Fecha de expedición del permiso de pesca
    FechaVigencia DATE NOT NULL, -- Fecha de vigencia del permiso de pesca
    EstatusPermiso BOOLEAN DEFAULT FALSE NOT NULL, -- Indica si el permiso de pesca está activo o no
    Nota TEXT, -- Nota del permiso de pesca
    TPPPescaid INT NOT NULL, -- Identificador del permiso de pesca
    UEPAMid INT NOT NULL, -- Identificador de la unidad económica de cooperativas
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPPPescaid) REFERENCES permisos_pesca(id), -- Llave foránea del permiso de pesca con el identificador del permiso de pesca-TPPPescaid
    FOREIGN KEY (UEPAMid) REFERENCES unidad_economica_pa_moral(id) -- Llave foránea de la unidad económica de cooperativas con el identificador de la unidad económica de cooperativas-UEPAMid
);

CREATE TABLE artes_pesca_permisos_pa_moral( -- Tabla para las artes de pesca por permiso de pesca por unidad económica de cooperativas
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador de la tabla
    TPArtPescaid INT NOT NULL, -- Identificador del arte de pesca
    PPPAMid INT NOT NULL, -- Identificador del permiso de pesca
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (PPPAMid) REFERENCES permisos_pesca_por_pa_moral(id), -- Llave foránea del permiso de pesca con el identificador del permiso de pesca-PPPAMid
    FOREIGN KEY (TPArtPescaid) REFERENCES artes_pesca(id) -- Llave foránea del arte de pesca con el identificador del arte de pesca-TPArtPescaid
);

CREATE TABLE tipos_actividad ( -- Tabla para los tipos de actividad
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del tipo de actividad
    NombreTipoActividad VARCHAR(50) NOT NULL, -- Nombre del tipo de actividad
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipos_cubierta ( -- Tabla para los tipos de cubierta
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del tipo de cubierta
    NombreTipoCubierta VARCHAR(50) NOT NULL, -- Nombre del tipo de cubierta
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE materiales_casco ( -- Tabla para los materiales de casco
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, -- Identificador del material de casco
    NombreMaterialCasco VARCHAR(50) NOT NULL, -- Nombre del material de casco
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE unidad_economica_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    RNPA VARCHAR(10),
    Nombre VARCHAR(50) NOT NULL,
    ActivoPropio BOOLEAN DEFAULT FALSE NOT NULL,
    UEDuenoid INT NOT NULL,
    NombreEmbMayor VARCHAR(50) NOT NULL,
    Matricula VARCHAR(15) NOT NULL,
    PuertoBase VARCHAR(50) NOT NULL,
    TPActid INT NOT NULL,
    TPCubid INT NOT NULL,
    CdPatrones INT NOT NULL,
    CdMotoristas INT NOT NULL,
    CdPescEspecializados INT NOT NULL,
    CdPescadores INT NOT NULL,
    AnioConstruccion INT NOT NULL,
    MtrlCascoid INT NOT NULL,
    Eslora DECIMAL(10, 2) DEFAULT 0.00,
    Manga DECIMAL(10, 2) DEFAULT 0.00,
    Puntal DECIMAL(10, 2) DEFAULT 0.00,
    Calado DECIMAL(10, 2) DEFAULT 0.00,
    ArqueoNeto DECIMAL(10, 2) DEFAULT 0.00,
    DocAcreditacionLegalMotor VARCHAR(255) NOT NULL,
    DocCertificadoMatricula VARCHAR(255) NOT NULL,
    DocComprobanteTenenciaLegal VARCHAR(255) NOT NULL,
    DocCertificadoSegEmbs VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEDuenoid) REFERENCES unidad_economica_pa_fisico(id),
    FOREIGN KEY (TPActid) REFERENCES tipos_actividad(id),
    FOREIGN KEY (TPCubid) REFERENCES tipos_cubierta(id),
    FOREIGN KEY (MtrlCascoid) REFERENCES materiales_casco(id)
);

CREATE TABLE embarcaciones_mayores_por_pa (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_deteccion (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipoDeteccion VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE sistemas_conservacion (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreSistemaConservacion VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE equipos_seguridad (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipoSeguridad VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE equipos_salvamento (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipoSalvamento VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE equipos_contraindencio (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipoContraIncendio VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE equipos_comunicacion (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipoComunicacion VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE equipos_navegacion (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipoNavegacion VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE artes_pesca_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    TPArtPescaid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPArtPescaid) REFERENCES artes_pesca(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_deteccion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoDeteccionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoDeteccionid) REFERENCES equipos_deteccion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE sistemas_conservacion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    SisConservacionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (SisConservacionid) REFERENCES sistemas_conservacion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE especies_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    TPEspecieid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_seguridad_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoSeguridadid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoSeguridadid) REFERENCES equipos_seguridad(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_salvamento_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoSalvamentoid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoSalvamentoid) REFERENCES equipos_salvamento(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_contraindencio_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoContraIncendioid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoContraIncendioid) REFERENCES equipos_contraindencio(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_comunicacion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoComunicacionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoComunicacionid) REFERENCES equipos_comunicacion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE equipos_navegacion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoNavegacionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoNavegacionid) REFERENCES equipos_navegacion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE motores_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Marca VARCHAR(20) NOT NULL,
    Modelo VARCHAR(10) NOT NULL,
    Serie VARCHAR(10) NOT NULL,
    Potencia DECIMAL(10, 2) DEFAULT 0.00,
    MtrPrincipal BOOLEAN DEFAULT FALSE NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE motores_por_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMAid INT NOT NULL,
    MtrEmbMaid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id),
    FOREIGN KEY (MtrEmbMaid) REFERENCES motores_emb_ma(id)
);

CREATE TABLE artes_equipo_pesca_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    TPArtPescaid INT NOT NULL,
    TPEspecieid INT NOT NULL,
    Cantidad INT NOT NULL,
    Longitud DECIMAL(10, 2) DEFAULT 0.00,
    Altura DECIMAL(10, 2) DEFAULT 0.00,
    Malla DECIMAL(10, 2) DEFAULT 0.00,
    Material VARCHAR(50) DEFAULT 0.00,
    Reinales DECIMAL(10, 2) DEFAULT 0.00,
    DocFacturaElectronica VARCHAR(255) NOT NULL,
    DocNotaRemision VARCHAR(255) NOT NULL,
    DocFacturaEndosada VARCHAR(255) NOT NULL,
    DocTestimonial VARCHAR(255) NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPArtPescaid) REFERENCES artes_pesca(id),
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE artes_equipo_pesca_por_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    ArteEquipoPescaEmbMaid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ArteEquipoPescaEmbMaid) REFERENCES artes_equipo_pesca_emb_ma(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);

CREATE TABLE costos_operaciones_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Combustible DECIMAL(10, 2) DEFAULT 0.00,
    Lubricantes DECIMAL(10, 2) DEFAULT 0.00,
    Mantenimiento DECIMAL(10, 2) DEFAULT 0.00,
    Salarios DECIMAL(10, 2) DEFAULT 0.00,
    Seguros DECIMAL(10, 2) DEFAULT 0.00,
    Permisos DECIMAL(10, 2) DEFAULT 0.00,
    Impuestos DECIMAL(10, 2) DEFAULT 0.00,
    Avituallamiento DECIMAL(10, 2) DEFAULT 0.00,
    Preoperativos DECIMAL(10, 2) DEFAULT 0.00,
    AsistenciaTecnica DECIMAL(10, 2) DEFAULT 0.00,
    Administrativos DECIMAL(10, 2) DEFAULT 0.00,
    Otros DECIMAL(10, 2) DEFAULT 0.00,
    Total DECIMAL(10, 2) DEFAULT 0.00 NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMAid) REFERENCES unidad_economica_emb_ma(id)
);



CREATE TABLE unidad_economica_emb_me(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    RNPA VARCHAR(10),
    Nombre VARCHAR(100) NOT NULL,
    UEDueno INT NOT NULL,
    NombreEmbarcacion VARCHAR(100) NOT NULL,
    Matricula VARCHAR(12) NOT NULL,
    TPActid INT NOT NULL,
    MtrlCascoid INT NOT NULL,
    CapacidadCarga DECIMAL(10, 2) DEFAULT 0.00,
    MedidaEslora DECIMAL(10, 2) DEFAULT 0.00,
    DocAcreditacionLegalMotor VARCHAR(255) NOT NULL,
    DocCertificadoMatricula VARCHAR(255) NOT NULL,
    DocTenenciaLegal VARCHAR(255) NOT NULL,
    DocCertificadoSeguridad VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEDueno) REFERENCES unidad_economica_pa_fisico(id),
    FOREIGN KEY (TPActid) REFERENCES tipos_actividad(id),
    FOREIGN KEY (MtrlCascoid) REFERENCES materiales_casco(id)
);

CREATE TABLE embarcaciones_menores_por_pa (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMEid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMEid) REFERENCES unidad_economica_emb_me(id)
);


CREATE TABLE tipos_motor (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreTipoMotor VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE motores_emb_me (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    TPMotorid INT NOT NULL,
    Marca VARCHAR(20) NOT NULL,
    Potencia DECIMAL(10, 2) DEFAULT 0.00,
    Serie VARCHAR(20) NOT NULL,
    Combustible VARCHAR(20) NOT NULL,
    UEEMMEid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPMotorid) REFERENCES tipos_motor(id),
    FOREIGN KEY (UEEMMEid) REFERENCES unidad_economica_emb_me(id)
);

CREATE TABLE motores_por_emb_me (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMEid INT NOT NULL,
    MtrEmbMeid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMEid) REFERENCES unidad_economica_emb_me(id),
    FOREIGN KEY (MtrEmbMeid) REFERENCES motores_emb_me(id)
);}
CREATE TABLE artes_equipo_pesca_emb_me (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    TPArtPescaid INT NOT NULL,
    TPEspecieid INT NOT NULL,
    Cantidad INT NOT NULL,
    Longitud DECIMAL(10, 2) DEFAULT 0.00,
    Altura DECIMAL(10, 2) DEFAULT 0.00,
    Malla DECIMAL(10, 2) DEFAULT 0.00,
    Material VARCHAR(50) NOT NULL,
    Reinales DECIMAL(10, 2) DEFAULT 0.00,
    DocFacturaElectronica VARCHAR(255) NOT NULL,
    DocNotaRemision VARCHAR(255) NOT NULL,
    DocFacturaEndosada VARCHAR(255) NOT NULL,
    DocTestimonial VARCHAR(255) NOT NULL,
    UEEMMEid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPArtPescaid) REFERENCES artes_pesca(id),
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id),
    FOREIGN KEY (UEEMMEid) REFERENCES unidad_economica_emb_me(id)
);

CREATE TABLE artes_equipo_pesca_por_emb_me (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMEid INT NOT NULL,
    ArteEquipoPescaEmbMeid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ArteEquipoPescaEmbMeid) REFERENCES artes_equipo_pesca_emb_me(id),
    FOREIGN KEY (UEEMMEid) REFERENCES unidad_economica_emb_me(id)
);


CREATE TABLE unidad_economica_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    RNPA VARCHAR(10),
    Nombre VARCHAR(100) NOT NULL,
    Cambio BOOLEAN DEFAULT FALSE,
    Arrendado BOOLEAN DEFAULT FALSE,
    UEDueno INT NOT NULL,
    NombreInstalacion VARCHAR(50) NOT NULL,
    Ubicacion VARCHAR(100) NOT NULL,
    Locid INT NOT NULL,
    Acceso TEXT NOT NULL,
    UsoComercial BOOLEAN DEFAULT FALSE,
    UsoDidacta BOOLEAN DEFAULT FALSE,
    UsoFomento BOOLEAN DEFAULT FALSE,
    UsoInvestigacion BOOLEAN DEFAULT FALSE,
    UsoRecreativo BOOLEAN DEFAULT FALSE,
    UsoOtro TEXT,
    TipoLaboratorio BOOLEAN DEFAULT FALSE,
    TipoGranja BOOLEAN DEFAULT FALSE,
    TipoCentroAcuicola BOOLEAN DEFAULT FALSE,
    TipoOtro TEXT,
    ModeloIntensivo BOOLEAN DEFAULT FALSE,
    ModeloSemiintensivo BOOLEAN DEFAULT FALSE,
    ModeloExtensivo BOOLEAN DEFAULT FALSE,
    ModeloHiperintensivo BOOLEAN DEFAULT FALSE,
    ModeloOtro TEXT,
    AreaTotal DECIMAL(10, 2) DEFAULT 0.00,
    AreaAcuicola DECIMAL(10, 2) DEFAULT 0.00,
    AreaRestante TEXT,
    DocActaCreacion VARCHAR(255) NOT NULL,
    DocPlanoInstalaciones VARCHAR(255) NOT NULL,
    DocAcreditacionLegalInstalacion VARCHAR(255) NOT NULL,
    DocComprobanteDomicilio VARCHAR(255) NOT NULL,
    DocEspeTecnicasFisicas VARCHAR(255) NOT NULL,
    DocMapaLocalizacion VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEDueno) REFERENCES unidad_economica_pa_fisico(id),
    FOREIGN KEY (Locid) REFERENCES localidades(id)
);

CREATE TABLE especies_objetivo (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    CpProduccionMiles INT NOT NULL,
    CpProduccionToneladas DECIMAL(10, 2) NOT NULL DEFAULT 0,
    TPEspeciesid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspeciesid) REFERENCES especies(id)
);

CREATE TABLE especies_objetivo_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    EspecieOid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id),
    FOREIGN KEY (EspecieOid) REFERENCES especies_objetivo(id)
);

CREATE TABLE tipos_activo (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreActivo VARCHAR(100) UNIQUE NOT NULL,
    Clave VARCHAR(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE activos_produccion_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    TPActivoid INT NOT NULL,
    Cantidad INT NOT NULL,
    Largo DECIMAL(10, 2) DEFAULT 0.00,
    Ancho DECIMAL(10, 2) DEFAULT 0.00,
    Altura DECIMAL(10, 2) DEFAULT 0.00,
    Capacidad DECIMAL(10, 2) DEFAULT 0.00,
    UnidadMedida ENUM (
        'METRO CUADRADO',
        'METRO CUBICO',
        'KILOGRAMO',
        'LITRO',
        'PIEZA'
    ) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPActivoid) REFERENCES tipos_activo(id),
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id)
);

CREATE TABLE activos_produccion_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    APIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id),
    FOREIGN KEY (APIAid) REFERENCES activos_produccion_ia(id)
);

CREATE TABLE fuentes_agua_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    FTPozoProfundo BOOLEAN DEFAULT FALSE,
    FTPozoCieloAbierto BOOLEAN DEFAULT FALSE,
    FTRio BOOLEAN DEFAULT FALSE,
    FTLago BOOLEAN DEFAULT FALSE,
    FTArroyo BOOLEAN DEFAULT FALSE,
    FTPresa BOOLEAN DEFAULT FALSE,
    FTMar BOOLEAN DEFAULT FALSE,
    FTOtro TEXT,
    FlujoAguaLxM DECIMAL(10, 2) DEFAULT 0.00,
    UEIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id)
);

CREATE TABLE fuentes_agua_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    FAIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id),
    FOREIGN KEY (FAIAid) REFERENCES fuentes_agua_ia(id)
);

CREATE TABLE administracion_trabajadores_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NumFamilias INT,
    NumMujeres INT,
    NumHombres INT,
    Integ15Menos INT,
    Integ16a25 INT,
    Integ26a35 INT,
    Integ36a45 INT,
    Integ46a60 INT,
    IntegMas60 INT,
    RequiereCont BOOLEAN DEFAULT FALSE,
    Temporales INT,
    Permanentes INT,
    TotalIntegrantes INT NOT NULL,
    UEIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id)
);

CREATE TABLE administracion_trabajadores_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    ATIAid INT NOT NULL,
    UEIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ATIAid) REFERENCES administracion_trabajadores_ia(id),
    FOREIGN KEY (UEIAid) REFERENCES unidad_economica_ia(id)
);

CREATE TABLE tipos_modalidad (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreModalidad VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipos_proceso (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreProceso VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipos_solicitud (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreSolicitud VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    FolioSolicitud VARCHAR(13) UNIQUE NOT NULL,
    FolioGenerado VARCHAR(13),
    FechaSolicitud DATE NOT NULL,
    TPProcesoid INT NOT NULL,
    TPModalidadid INT NOT NULL,
    TPSolicitudid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPProcesoid) REFERENCES tipos_proceso(id),
    FOREIGN KEY (TPModalidadid) REFERENCES tipos_modalidad(id),
    FOREIGN KEY (TPSolicitudid) REFERENCES tipos_solicitud(id)
);

---- Vistas ----

CREATE VIEW vista_solicitudes AS
SELECT
    solicitudes.FolioSolicitud AS "Folio de la solicitud",
    solicitudes.FechaSolicitud AS "Fecha de la solicitud",
    tipos_proceso.NombreProceso AS "Proceso de la solicitud",
    tipos_modalidad.NombreModalidad AS "Modalidad de la solicitud",
    tipos_solicitud.NombreSolicitud AS "Tipo de la solicitud"
FROM solicitudes
INNER JOIN tipos_proceso ON solicitudes.TPProcesoid = tipos_proceso.id
INNER JOIN tipos_modalidad ON solicitudes.TPModalidadid = tipos_modalidad.id
INNER JOIN tipos_solicitud ON solicitudes.TPSolicitudid = tipos_solicitud.id;


---- Indices ----

CREATE INDEX idx_NombreRol ON roles(NombreRol); -- Indice para el nombre del rol

CREATE INDEX idx_Curp ON users(CURP); -- Indice para la curp del usuario
CREATE INDEX idx_Email ON users(Email); -- Indice para la curp del usuario
CREATE INDEX idx_Rolid ON users(Rolid); -- Indice para el rol del usuario
