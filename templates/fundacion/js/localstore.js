var storelocal = (function(){
    function isStorageSupported($window, storageType) {
      var supported;
      try {
        supported = $window[storageType];
      }
      catch(err) {
        supported = false;
      }

      if(supported && storageType === 'localStorage') {
        var key = '__' + Math.round(Math.random() * 1e7);

        try {
          localStorage.setItem(key, key);
          localStorage.removeItem(key);
        }
        catch(err) {
          supported = false;
        }
      }

      return supported;
    }

    var providerWebStorage = isStorageSupported(window, 'localStorage');

    var prefix = 'fj-';

    var serializer = function(obj, pretty) {
        if (typeof obj === 'undefined') return undefined;

        if (typeof pretty === 'number') {
            pretty = pretty ? 2 : null;
        }

        return JSON.stringify(obj, undefined, pretty);
    }

    var deserializer = function(json) {

        return JSON.parse(json);
    }

    return {
        setKeyPrefix: function(prefix){
            if (typeof prefix !== 'string') {
                throw new TypeError('[localStore] - setKeyPrefix se debe de proveer una cadena.');
            }

            prefix = prefix;
        },
        setSerializer: function(s){
            if(typeof s !== 'function'){
                throw new TypeError('[localStore] - setSerializer se debe de proveer de una función.');
            }

            serializer = s;
        },
        setDeserializer: function (d) {
            if (typeof d !== 'function') {
                throw new TypeError('[localStore] - setDeserializer  se debe de proveer de una función.');
            }

            deserializer = d;
        },
        supported: function() {
            return !!providerWebStorage;
        },
        get: function (key) {
            return providerWebStorage && deserializer(providerWebStorage.getItem(prefix + key));
        },
        set: function (key, value) {
            return providerWebStorage && providerWebStorage.setItem(prefix + key, serializer(value));
        },
        drop: function (key) {
            return providerWebStorage && providerWebStorage.removeItem(prefix + key);
        }
    };
}());

window.$localStore = storelocal;
