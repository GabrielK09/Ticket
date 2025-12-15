package pkg

import (
	"errors"
	"io/fs"
	"log"
	"os"
)

func validateDir(p string) bool {
	info, err := os.Stat(p)

	return err == nil && info.IsDir()
}

func CheckExistsPath(paths ...string) (string, error) {
	for _, path := range paths {
		if _, err := os.Stat(path); err == nil {
			return path, nil
		} else if !errors.Is(err, fs.ErrNotExist) {
			return "", err
		}
	}

	return "", nil
}

func SetDier(firstDir, otherDir string) (string, error) {
	switch {
	case validateDir(firstDir):
		_, err := os.Stat(firstDir)

		if err != nil {
			log.Println("Erro ao validar o primeiro caminho: ", err)
			return "", err
		}

		return firstDir, nil

	case validateDir(otherDir):
		_, err := os.Stat(otherDir)

		if err != nil {
			log.Println("Erro ao validar o segundo caminho: ", err)
			return "", err
		}

		return otherDir, nil

	default:
		log.Printf("Erro ao acessar os dois caminhos: %s | %s", firstDir, otherDir)
		return "", nil
	}
}
