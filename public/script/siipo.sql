

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreRol VARCHAR(20) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Nombre VARCHAR(30) NOT NULL,
    CURP VARCHAR(18) UNIQUE NOT NULL,
    Email VARCHAR(30),
    Password VARCHAR(20) NOT NULL,
    Rolid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Rolid) REFERENCES roles(id)
);

CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombrePermiso VARCHAR(30) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE asignacion_permisos (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Rolid INT NOT NULL,
    Perid INT NOT NULL,
    Permitido BOOLEAN DEFAULT FALSE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Rolid) REFERENCES roles(id),
    FOREIGN KEY (Perid) REFERENCES permisos(id)
);

CREATE TABLE regiones (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreRegion VARCHAR(40) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE distritos (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreDistrito VARCHAR(30) UNIQUE NOT NULL,
    Regid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Regid) REFERENCES regiones(id)
);

CREATE TABLE municipios (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreMunicipio VARCHAR(30) NOT NULL,
    Disid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Disid) REFERENCES distritos(id)
);

CREATE TABLE localidades (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreLocalidad VARCHAR(30) NOT NULL,
    Munid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Munid) REFERENCES municipios(id)
);

CREATE TABLE oficinas (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreOficina VARCHAR(50) NOT NULL,
    Ubicacion VARCHAR(100) NOT NULL,
    Telefono VARCHAR(10) NOT NULL,
    Email VARCHAR(40) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE unidades_economicas_pa_fisico (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Ofcid INT NOT NULL,
    FechaRegistro DATE NOT NULL,
    RNPA VARCHAR(10),
    CURP VARCHAR(18) UNIQUE NOT NULL,
    RFC VARCHAR(13),
    Nombres VARCHAR(50) NOT NULL,
    ApPaterno VARCHAR(30) NOT NULL,
    ApMaterno VARCHAR(30) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    Sexo ENUM ('M', 'F') NOT NULL,
    GrupoSanguineo VARCHAR(4),
    Email VARCHAR(40),
    Calle VARCHAR(100) NOT NULL,
    NmExterior VARCHAR(6) NOT NULL,
    NmInterior VARCHAR(6) NOT NULL,
    CodigoPostal VARCHAR(10),
    Locid INT NOT NULL,
    IniOperaciones DATE NOT NULL,
    ActivoEmbMayor BOOLEAN DEFAULT FALSE NOT NULL,
    ActivoEmbMenor BOOLEAN DEFAULT FALSE NOT NULL,
    ActvAcuacultura BOOLEAN DEFAULT FALSE NOT NULL,
    ActvPesca BOOLEAN DEFAULT FALSE NOT NULL,
    NmPrincipal VARCHAR(10) NOT NULL,
    TpPrincipal VARCHAR(20) NOT NULL,
    NmSecundario VARCHAR(10) NOT NULL,
    TpSecundario VARCHAR(20) NOT NULL,
    DocActaNacimiento VARCHAR(255) NOT NULL,
    DocComprobanteDomicilio VARCHAR(255) NOT NULL,
    DocCURP VARCHAR(255) NOT NULL,
    DocIdentificacionOfc VARCHAR(255) NOT NULL,
    DocRFC VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Ofcid) REFERENCES oficinas(id),
    FOREIGN KEY (Locid) REFERENCES localidades(id)
);

CREATE TABLE artes_pesca (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreArtePesca VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE especies (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEspecie VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreComun VARCHAR(50) NOT NULL,
    NombreCientifico VARCHAR(100) NOT NULL,
    TPEspecieid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id)
);

CREATE TABLE permisos_pesca (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombrePermiso VARCHAR(50) NOT NULL,
    TPEspecieid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id)
);



CREATE TABLE unidades_economicas_pa_moral (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEDuenoid INT NOT NULL,
    Ofcid INT NOT NULL,
    FechaRegistro DATE NOT NULL,
    RNPA VARCHAR(10) NOT NULL,
    RFC VARCHAR(13) NOT NULL,
    RazonSocial VARCHAR(50) NOT NULL,
    Email VARCHAR(40),
    Calle VARCHAR(100) NOT NULL,
    NmExterior VARCHAR(6) NOT NULL,
    NmInterior VARCHAR(6) NOT NULL,
    CodigoPostal VARCHAR(10),
    LocID INT NOT NULL,
    NmPrincipal VARCHAR(10) NOT NULL,
    TpPrincipal VARCHAR(20) NOT NULL,
    NmSecundario VARCHAR(10) NOT NULL,
    TpSecundario VARCHAR(20) NOT NULL,
    IniOperaciones DATE NOT NULL,
    ActvAcuacultura BOOLEAN DEFAULT FALSE NOT NULL,
    ActvPesca BOOLEAN DEFAULT FALSE NOT NULL,
    ActivoEmbMayor BOOLEAN DEFAULT FALSE NOT NULL,
    ActivoEmbMenor BOOLEAN DEFAULT FALSE NOT NULL,
    CantidadPescadores INT,
    DocActaConstitutiva VARCHAR(255) NOT NULL,
    DocActaAsamblea VARCHAR(255) NOT NULL,
    DocRepresentanteLegal VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Ofcid) REFERENCES oficinas(id),
    FOREIGN KEY (Locid) REFERENCES localidades(id),
    FOREIGN KEY (UEDuenoid) REFERENCES unidades_economicas_pa_fisico(id)
);

CREATE TABLE socios_detalles_pa_moral (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    CURP VARCHAR(18) NOT NULL,
    ActvPesca BOOLEAN DEFAULT TRUE NOT NULL,
    ActvAcuacultura BOOLEAN DEFAULT TRUE NOT NULL,
    DocActaNacimiento VARCHAR(255) NOT NULL,
    DocComprobanteDomicilio VARCHAR(255) NOT NULL,
    DocCURP VARCHAR(255) NOT NULL,
    DocIdentificacionOfc VARCHAR(255) NOT NULL,
    DocRFC VARCHAR(255) NOT NULL,
    UEPAMid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEPAMid) REFERENCES unidades_economicas_pa_moral(id)
);



CREATE TABLE tipos_actividad (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreTipoActividad VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tipos_cubierta (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreTipoCubierta VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE materiales_casco (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreMaterialCasco VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE unidades_economicas_emb_ma (
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
    FOREIGN KEY (UEDuenoid) REFERENCES unidades_economicas_pa_fisico(id),
    FOREIGN KEY (TPActid) REFERENCES tipos_actividad(id),
    FOREIGN KEY (TPCubid) REFERENCES tipos_cubierta(id),
    FOREIGN KEY (MtrlCascoid) REFERENCES materiales_casco(id)
);

CREATE TABLE equipos_deteccion (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    NombreEquipo VARCHAR(50),
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

CREATE TABLE equipos_contraincendio (
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
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE equipos_deteccion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoDeteccionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoDeteccionid) REFERENCES equipos_deteccion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE sistemas_conservacion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    SisConservacionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (SisConservacionid) REFERENCES sistemas_conservacion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE especies_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    TPEspecieid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (TPEspecieid) REFERENCES especies(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE equipos_seguridad_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoSeguridadid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoSeguridadid) REFERENCES equipos_seguridad(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE equipos_salvamento_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoSalvamentoid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoSalvamentoid) REFERENCES equipos_salvamento(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE equipos_contraindencio_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoContraincendioid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoContraincendioid) REFERENCES equipos_contraincendio(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE equipos_comunicacion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoComunicacionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoComunicacionid) REFERENCES equipos_comunicacion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE equipos_navegacion_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    EqpoNavegacionid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (EqpoNavegacionid) REFERENCES equipos_navegacion(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
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
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE motores_por_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMAid INT NOT NULL,
    MtrEmbMaid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id),
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
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE artes_equipo_pesca_por_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    ArteEquipoPescaEmbMaid INT NOT NULL,
    UEEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ArteEquipoPescaEmbMaid) REFERENCES artes_equipo_pesca_emb_ma(id),
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
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
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id)
);

CREATE TABLE costos_operaciones_por_emb_ma (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMAid INT NOT NULL,
    COEMMAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMAid) REFERENCES unidades_economicas_emb_ma(id),
    FOREIGN KEY (COEMMAid) REFERENCES costos_operaciones_emb_ma(id)
);



CREATE TABLE unidades_economicas_emb_me(
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
    FOREIGN KEY (UEDueno) REFERENCES unidades_economicas_pa_fisico(id),
    FOREIGN KEY (TPActid) REFERENCES tipos_actividad(id),
    FOREIGN KEY (MtrlCascoid) REFERENCES materiales_casco(id)
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
    FOREIGN KEY (UEEMMEid) REFERENCES unidades_economicas_emb_me(id)
);

CREATE TABLE motores_por_emb_me (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMEid INT NOT NULL,
    MtrEmbMeid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEEMMEid) REFERENCES unidades_economicas_emb_me(id),
    FOREIGN KEY (MtrEmbMeid) REFERENCES motores_emb_me(id)
);

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
    FOREIGN KEY (UEEMMEid) REFERENCES unidades_economicas_emb_me(id)
);

CREATE TABLE artes_equipo_pesca_por_emb_me (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEEMMEid INT NOT NULL,
    ArteEquipoPescaEmbMeid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ArteEquipoPescaEmbMeid) REFERENCES artes_equipo_pesca_emb_me(id),
    FOREIGN KEY (UEEMMEid) REFERENCES unidades_economicas_emb_me(id)
);

CREATE TABLE unidades_economicas_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    RNPA VARCHAR(10),
    Nombre VARCHAR(100) NOT NULL,
    Propietario BOOLEAN DEFAULT FALSE,
    Arrendado BOOLEAN DEFAULT FALSE,
    UEDueno INT NOT NULL,
    NombreInstalacion VARCHAR(50) NOT NULL,
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
    FOREIGN KEY (UEDueno) REFERENCES unidades_economicas_pa_fisico(id),
    FOREIGN KEY (Locid) REFERENCES localidades(id)
);

CREATE TABLE especies_objetivo_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    EspObjetivoid INT NOT NULL,
    CpProduccionMiles INT NOT NULL,
    CpProduccionToneladas DECIMAL(10, 2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id),
    FOREIGN KEY (EspObjetivoid) REFERENCES especies(id)
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
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id)
);

CREATE TABLE activos_produccion_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    APIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id),
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
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id)
);

CREATE TABLE fuentes_agua_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    UEIAid INT NOT NULL,
    FAIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id),
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
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id)
);

CREATE TABLE administracion_trabajadores_por_ia (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    ATIAid INT NOT NULL,
    UEIAid INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ATIAid) REFERENCES administracion_trabajadores_ia(id),
    FOREIGN KEY (UEIAid) REFERENCES unidades_economicas_ia(id)
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
