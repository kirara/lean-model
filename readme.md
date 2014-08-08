LeanModel
=========
Model skeleton for Nette 2.2 based on Leanmapper ORM

Add to `config.neon`:
```
extensions:
	leanModel: Saman\LeanModel\LeanModelExtension

leanModel:
	defaultEntityNamespace: "defaultEntityNamespace"  # "App\Model" if not set
	mapper: Saman\LeanModel\Mapper
	entityFactory: Saman\LeanModel\EntityFactory
```
and to `config.local.neon`:
```
leanModel:
	host: "hostName"
	username: "userName"
	password: "password"
	database: "databaseName"
	profiler: on|off
```